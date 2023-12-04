<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendors()
    {
        if (request()->ajax()) {
            $users = User::role('vendor')->get();

            return datatables()->of($users)
                ->editColumn('avatar', function ($row) {
                    return $row->avatar ? '<img src="' . $row->ProfileUrl . '" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('admin', function ($row) {
                    return $row->admin->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="' . route('profile.index', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="user-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['avatar', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('users.vendors');
    }
    public function users()
    {
        if (request()->ajax()) {
            $users = User::role('user')->get();

            return datatables()->of($users)
                ->editColumn('avatar', function ($row) {
                    return $row->avatar ? '<img src="' . $row->ProfileUrl . '" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('admin', function ($row) {
                    return $row->admin->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="' . route('profile.index', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="user-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['avatar', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('users.users');
    }

    public function admins()
    {
        if (request()->ajax()) {
            $users = User::role('admin')->get();

            return datatables()->of($users)
                ->editColumn('avatar', function ($row) {
                    return $row->avatar ? '<img src="' . $row->ProfileUrl . '" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="' . route('profile.index', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="user-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['avatar', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('users.admins');
    }


    public function myAdmins($user_id)
    {
        if (request()->ajax()) {
            $users = User::where('user_id', $user_id)->get();

            return datatables()->of($users)
                ->editColumn('avatar', function ($row) {
                    return $row->avatar ? '<img src="' . $row->ProfileUrl . '" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="' . route('profile.index', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="user-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['avatar', 'action'])

                ->addIndexColumn()
                ->make(true);
        }

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = CustomerGroup::all();
        return view('users.create-user',compact('groups'));
    }

    public function createAdmin()
    {
        $groups = CustomerGroup::all();

        return view('users.create-admin',compact('groups'));
    }
    public function createvendor()
    {
        $groups = CustomerGroup::all();

        return view('users.create-vendor',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'website' => $request->website,
            'address' => $request->address,
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'password' => bcrypt($request->password),
            'user_id' => Auth::user()->id,
            'group_id' => $request->group_id,
        ]);

        $plan = Plan::where('name', 'Free Plan')->first();

        if (!$plan) {
            $plan = new Plan();
            $plan->name = 'Free Plan';
            $plan->price = 0;
            $plan->period = 14;
            $plan->save();
        }
        $sub = new Subscription();
        $sub->user_id = $user->id;
        $sub->plan_id = $plan->id;
        $sub->save();

        $sub->start_date = Carbon::today();
        $sub->end_date = $sub->start_date->copy()->addDays($plan->period);
        $sub->save();

        $user->assignRole($request->role);

        switch ($request->role) {
            case 'admin':
                return redirect()->route('users.admins')
                    ->with('success', 'Subscription has been added successfully');
                break;

            case 'vendor':
                return redirect()->route('users.vendors')
                    ->with('success', 'Subscription has been added successfully');
                break;
            case 'user':
                return redirect()->route('users.users')
                    ->with('success', 'Subscription has been added successfully');
                break;


        }

        return redirect()->back();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'work';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::find($id)->delete()) {
            return response()->json(['msg' => 'User deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }
}
