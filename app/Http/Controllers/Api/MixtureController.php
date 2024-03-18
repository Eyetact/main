<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\ComponentsSet;
use App\Models\Admin\Mixture;
use App\Models\Admin\Software;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\MixtureResource;

class MixtureController extends ApiController
{
    public function __construct()
    {
        $this->resource = MixtureResource::class;
        $this->model = app(Mixture::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {
        return $this->store($request->all());
    }

    public function edit($id, Request $request)
    {


        return $this->update($id, $request->all());

    }

    public function mixtures($id)
    {
        $machine = Software::find($id);
        $component_id = ComponentsSet::where('main_part_id', $machine->main_part_id)
            ->first()->id;
            // dd($component_id);


            $mixtures = Mixture::where('components_set_id',   $component_id)
            ->where(function ($query) use ($machine) {
                $query->where('customer_id', auth()->user()->id)
                    ->orWhere('customer_group_id', $machine->customer_group_id)
                    ->orWhere('user_id', auth()->user()->id);
            })
            ->get();
            // dd($mixtures);




        return $this->returnData('data', MixtureResource::collection($mixtures), __('Get successfully'));

    }
}
