<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Requests\PlanRequest;
use Spatie\Permission\Models\Permission;



class PlanController extends Controller
{


    public function index()
    {
        if (request()->ajax()) {
            if(auth()->user()->hasRole('super'))
            {

                $plans = Plan::all();


            }


            else{
            $userId = auth()->user()->id;


            $plans = Plan::where('user_id', $userId)
                ->get();
            }

            return datatables()->of($plans)
                ->editColumn('image', function ($row) {
                    return $row->image ? '<img src="' . asset($row->image) . '" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('action', 'plans.action')
                ->rawColumns(['image', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('plans.list');
    }


    public function create()
    {

        $permissions = Permission::all();
        $user_permissions = Permission::where('type', 'user')->get();
        $customer_permissions = Permission::where('type', 'customer')->get();
        $allPermission = Permission::all();
        $groupPermission = $allPermission->groupBy('module');

        $availableModel= (auth()->user()->model_limit) - (auth()->user()->current_model_limit);
        $availableData= auth()->user()->data_limit;


        return view('plans.create', compact('permissions','user_permissions','customer_permissions','allPermission','groupPermission','availableModel','availableData'));
    }

    public function store(Request $request)
    {



        $plan = Plan::create($request->except('permissions','checkAll'));
        $plan->user_id = auth()->user()->id;
        $plan->save();

        if ($request->permissions) {
            foreach ($request->permissions as $p) {

                $per = Permission::find($p);

                $plan->permissions()->save($per);
            }
        }


        return redirect()->route('plans.index')
            ->with('success', 'Plan has been added successfully');
        ;



    }


    public function show($id)
    {
        $permissions = Permission::all();
        $user_permissions = Permission::where('type', 'user')->get();
        $customer_permissions = Permission::where('type', 'customer')->get();
        $plan = Plan::findOrFail($id);
        $allPermission = Permission::all();
        $groupPermission = $allPermission->groupBy('module');
        return view('plans.show', compact('plan', 'permissions','user_permissions','customer_permissions','allPermission','groupPermission'));
    }


    // public function edit(string $id)
    // {
    //     $plan = Plan::findOrFail($id);
    //     return view('plans.show',compact('plan'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = Plan::findOrFail($id);

        if ($request->has('image') && $plan->image && File::exists($plan->image)) {
            unlink($plan->image);
        }

        $plan->update($request->except('permissions','checkAll'));

        $plan->permissions()->detach();

        if ($request->permissions) {
        foreach ($request->permissions as $p) {

            $per = Permission::find($p);

            $plan->permissions()->save($per);
        }

        $subs = $plan->subscriptions;
        foreach ($subs as $sub) {
            $user = $sub->user;
            foreach($plan->permissions as $p) {
                $user->givePermissionTo($p);
            }

        }



    }
        return redirect()->route('plans.index')
            ->with('success', 'Plan has been updated successfully');
    }

    public function destroy($id)
    {
        if (Plan::find($id)->delete()) {
            return response()->json(['msg' => 'Plan deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }
}
