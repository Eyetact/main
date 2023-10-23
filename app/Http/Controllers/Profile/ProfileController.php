<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index($id = null)
    {
        $user_id = !filled($id) ? Auth::id() : $id;
        $user = User::where("id",$user_id)->first();
        return view('profile.index',compact('user'));
    }

    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'website' => 'required'
        ]);
        if(count($validator->errors()) > 0){
            return redirect()->route('profile.index')->withErrors($validator->errors());
        }
        $user_id = !filled($id) ? Auth::id() : $id;
        $user = User::where('id',$user_id)->first();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->save();

        Session::flash('success','Profile updated successfully.');
        return redirect()->back();
    }
}
