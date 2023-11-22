<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::all();

            return datatables()->of($users)
                ->editColumn('avatar', function($row){
                    return $row->avatar ? '<img src="' . asset($row->avatar) .'" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
    
                    </a>
    
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="'. route('users.view',$row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="'. $row->id .'" class="user-delete">Delete</a>
                        </li>
                    </ul>
                </div>';
                   
                    return $btn;
                })
                ->rawColumns(['avatar','action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('users.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $role = 'vendor';
        if (Auth::user()->hasRole('super')) {
            $role = 'admin';
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->email,
            'website' => $request->username,
            'address' => $request->address,
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($role);

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
