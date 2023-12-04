<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index($id = null)
    {
        $user_id = $id == null ? Auth::id() : $id;
        // dd( $user_id );
        $user = User::find( $user_id );
        $subscriptions = $user->subscriptions;
        $groups = CustomerGroup::all();


        if (request()->ajax()) {
            // $subscriptions = Subscription::where('user_id', $user_id)->get();

            return datatables()->of($subscriptions)

                ->editColumn('plan_id', function ($row) {
                    return $row->plan_id ? $row->plan?->name : " ";
                })


                ->editColumn('user_id', function ($row) {
                    return $row->user->username;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="' . route('subscriptions.view', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="subscription-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['plan_id', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('profile.index', compact('user','groups'));
    }

    public function update(Request $request, $id = null)
    {
        //        dd($request->all());
        $user_id = $id == null ? Auth::id() : $id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users,email,' . $user_id,
            'phone' => 'required',
            'address' => 'required',
            'website' => 'required'
        ]);
        if (count($validator->errors()) > 0) {
            return redirect()->route('profile.index')->withErrors($validator->errors());
        }

        $user = User::where('id', $user_id)->first();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->group_id = $request->group_id;
        $user->save();

        Session::flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }

    public function changePassword(Request $request, $id = null)
    {
        $user_id = $id == null ? Auth::id() : $id;
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);
        if (count($validator->errors()) > 0) {
            return redirect()->route('profile.index')->withErrors($validator->errors());
        }

        $user = User::where('id', $user_id)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::flash('success', 'Password has been changed successfully.');
        return redirect()->route('profile.index');
    }

    public function uploadProfileImage(Request $request, $id = null)
    {
        if ($request->hasFile('image_upload')) {
            $filename = $request->image_upload->getClientOriginalName();
            $destinationPath = 'uploads/users';
            $request->image_upload->move($destinationPath, $filename);
            $request->merge(['avatar' => $filename]);

            $user_id = $id == null ? Auth::id() : $id;
            $user = User::where('id', $user_id)->first();
            $user->avatar = $request->avatar;
            $user->save();

            Session::flash('success', 'Profile image updated successfully.');
            return redirect()->route('profile.index');
        }
    }
}
