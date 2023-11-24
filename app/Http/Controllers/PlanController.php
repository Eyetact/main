<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Requests\PlanRequest;



class PlanController extends Controller
{


    public function index()
    {
        if (request()->ajax()) {
            $plans = Plan::all();

            return datatables()->of($plans)
                ->editColumn('image', function($row){
                    return $row->image ? '<img src="' . asset($row->image) .'" alt="user-img" class="avatar-xl rounded-circle mb-1">' : "<span>No Image</span>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item">
                        <a  href="'. route('plans.view',$row->id) . '">View or Edit</a>
                        </li>

                        <li class="dropdown-item">
                        <a  href="#" data-id="'. $row->id .'" class="plan-delete">Delete</a>
                        </li>
                    </ul>
                </div>';

                    return $btn;
                })
                ->rawColumns(['image','action'])

                ->addIndexColumn()
                ->make(true);
        }
        return view('plans.list');
    }


    public function create()
    {
        return view('plans.create');
    }

    public function store(PlanRequest $request)
    {

        Plan::create($request->all());



        return redirect()->route('plans.index')
         ->with('success','Plan has been added successfully');;


    }


    public function show($id)
    {
        $plan = Plan::findOrFail($id);
        return view('plans.show',compact('plan'));
    }


    // public function edit(string $id)
    // {
    //     $plan = Plan::findOrFail($id);
    //     return view('plans.show',compact('plan'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, string $id)
    {
        $plan = Plan::findOrFail($id);

        if ($request->has('image') && $plan->image && File::exists($plan->image)) {
            unlink($plan->image);
        }

        $plan->update($request->all());


        return redirect()->route('plans.index')
                        ->with('success','Plan has been updated successfully');
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
