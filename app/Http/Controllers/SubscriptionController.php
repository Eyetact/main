<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;


class SubscriptionController extends Controller {

    public function index() {
        if(request()->ajax()) {
            $subscriptions = Subscription::all();

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
                        <a  href="#" id="edit_item" data-path="'.route('subscriptions.view', $row->id).'">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="'.$row->id.'" class="subscription-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['plan_id', 'action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('subscriptions.list');
    }

    public function create() {

        $users = User::all();
        $plans = Plan::all();
        $groups = CustomerGroup::all();

        return view('subscriptions.create', compact('users', 'plans', 'groups'));

    }

    public function store(Request $request) {

        if($request->group_id) {
            $group = CustomerGroup::find($request->group_id);
            foreach($group->customers as $customer) {

                $sub = new Subscription();
                $sub->user_id = $customer->id;
                $sub->plan_id = $request->plan_id;
                $sub->save();

                $plan = Plan::find($sub->plan_id);

                $sub->start_date = Carbon::today();
                $sub->end_date = $sub->start_date->copy()->addDays($plan->period);
                $sub->save();

                $user = User::find($customer->id);
                foreach($plan->permissions as $p) {
                    $user->givePermissionTo($p);
                }
            }

            return redirect()->route('subscriptions.index')
                ->with('success', 'Subscription has been added successfully');
        }

        $sub = Subscription::create($request->all());

        $plan = Plan::find($sub->plan_id);

        $sub->start_date = Carbon::today();
        $sub->end_date = $sub->start_date->copy()->addDays($plan->period);
        $sub->save();
        $user = User::find($request->user_id);
        foreach($plan->permissions as $p) {
            $user->givePermissionTo($p);
        }

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription has been added successfully');



    }

    public function show($id) {
        $subscription = Subscription::findOrFail($id);
        $users = User::all();
        $plans = Plan::all();
        return view('subscriptions.show', compact('subscription', 'users', 'plans'));

    }

    // public function edit(string $id)
    // {
    //     $plan = Plan::findOrFail($id);
    //     return view('plans.show',compact('plan'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $subscription = Subscription::findOrFail($id);

        $subscription->update($request->all());

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription has been updated successfully');
    }

    public function destroy($id) {
        if(Subscription::find($id)->delete()) {
            return response()->json(['msg' => 'Subscription deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }

}
