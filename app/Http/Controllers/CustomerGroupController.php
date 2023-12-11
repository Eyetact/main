<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $groups = CustomerGroup::all();

            return datatables()->of($groups)
               
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a id="edit_item" data-path="' . route('groups.view', $row->id) . '" href="#">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="' . $row->id . '" class="group-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns([ 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('groups.list');
    }

    
    public function create()
    {

        return view('groups.create');
    }

    public function store(Request $request)
    {

        $group = CustomerGroup::create($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'group has been added successfully');
        ;


    }


    public function show($id)
    {
        $group = CustomerGroup::findOrFail($id);


    

        return view('groups.show', compact('group'));
    }

    public function showCustomer($id)
    {
        $group = CustomerGroup::findOrFail($id);


        if (request()->ajax()) {
            // $subscriptions = Subscription::where('user_id', $user_id)->get();
            $users = $group->customers;
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

        return view('groups.show', compact('group'));
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
        $group = CustomerGroup::findOrFail($id);

        $group->update($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'group has been updated successfully');
    }

    public function destroy($id)
    {
        if (CustomerGroup::find($id)->delete()) {
            return response()->json(['msg' => 'group deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }
}
