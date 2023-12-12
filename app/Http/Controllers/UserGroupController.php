<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Models\Role;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $groups = UserGroup::all();

            return datatables()->of($groups)

            ->addColumn('role', function ($row) {
                return $row->roles?->first()?->name;
            })

                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a href="#" id="edit_item"  data-path="' . route('ugroups.view', $row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="group-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns([ 'action','role'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('users_groups.list');
    }


    public function create()
    {

        $roles = Role::where('name','!=','admin')
        ->where('name','!=','vendor')
        ->where('name','!=','super')
        ->get();

        return view('users_groups.create',compact('roles'));
    }

    public function store(Request $request)
    {

        $group = UserGroup::create($request->except('role'));

        $group->assignRole($request->role);

        return redirect()->route('ugroups.index')
            ->with('success', 'group has been added successfully');
        ;


    }


    public function show($id)
    {
        $group = UserGroup::findOrFail($id);

        $roles = Role::where('name','!=','admin')
        ->where('name','!=','vendor')
        ->where('name','!=','super')
        ->get();

        

        return view('users_groups.show', compact('group','roles'));
    }

    public function showUsers($id){
        if (request()->ajax()) {
        $group = UserGroup::findOrFail($id);

            // $subscriptions = Subscription::where('user_id', $user_id)->get();
            $users = $group->users;
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


    // public function edit(string $id)
    // {
    //     $group = group::findOrFail($id);
    //     return view('groups.show',compact('group'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = UserGroup::findOrFail($id);

        $group->update($request->except('role'));

        $group->assignRole($request->role);

        return redirect()->route('ugroups.index')
            ->with('success', 'group has been updated successfully');
    }

    public function destroy($id)
    {
        if (UserGroup::find($id)->delete()) {
            return response()->json(['msg' => 'group deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }
}
