<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;

class SubscriptionController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $subscriptions = Subscription::all();

            return datatables()->of($subscriptions)

            ->editColumn('plan_id', function($row){
                return $row->plan_id ? $row->plan?->name : " ";
            })

                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="'. route('subscriptions.view',$row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="'. $row->id .'" class="subscription-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['plan_id','action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('subscriptions.list');
    }


    public function create()
    {

        $users = User::all();
        $plans = Plan::all();

        return view('subscriptions.create',compact('users','plans'));

    }

    public function store(Request $request)
    {

        $sub=Subscription::create($request->all());


        $plan = Plan::find($sub->plan_id);

    $sub->start_date = Carbon::today();
    $sub->end_date = $sub->start_date->copy()->addDays($plan->period);
    $sub->save();

        return redirect()->route('subscriptions.index')
         ->with('success','Subscription has been added successfully');;


    }


    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        $users = User::all();
        $plans = Plan::all();
        return view('subscriptions.show',compact('subscription','users','plans'));

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
        $subscription = Subscription::findOrFail($id);



        $subscription->update($request->all());




        return redirect()->route('subscriptions.index')
                        ->with('success','Subscription has been updated successfully');
    }

    public function destroy($id)
    {
        if (Subscription::find($id)->delete()) {
            return response()->json(['msg' => 'Subscription deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }


}
