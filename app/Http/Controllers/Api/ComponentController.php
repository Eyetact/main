<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\Component;
use App\Models\Admin\ComponentsSet;
use App\Models\Admin\Software;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ComponentResource;

class ComponentController extends ApiController
{
    public function __construct()
    {
        $this->resource = ComponentResource::class;
        $this->model = app(Component::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {



        $model = new Component();
        $model->compo_name = $request->name;
        $model->element_id = $request->element_id;
        $model->compo_concentration = $request->concentration;
        $model->unit_id = $request->unit_id;
        $model->compo_carrier = $request->compo_carrier;

        // $decodedCategories = is_array($request->compo_category) ? $request->compo_category : json_decode($request->compo_category, true);
        // if (!is_array($decodedCategories)) {
        //     return $this->returnError(__('Invalid compo_category data.'));
        // }

        $setCategories = [];
        $index = 1;
        foreach ($request->compo_category as $item) {
            if (!isset($item['name'])) {
                return $this->returnError(__('Invalid category name.'));
            }

            $setCategories[$index] = [
                'name' => $item['name'],
                'minimum'=> $item['minimum'],
                'maximum'=> $item['maximum'],
                'default'=> $item['default'],
            ];
            $index++;
        }

        // $encodedComponents = json_encode($setComponents, JSON_UNESCAPED_UNICODE);
        // $encodedComponents = preg_replace('/\\\\/', '', $encodedComponents);

        $model->compo_category = $setCategories;
        $model->user_id = auth()->user()->id;
        $model->save();


        if ($model) {




            return $this->returnData('data', new $this->resource($model), __('Succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to create !'));

    }

    public function edit($id, Request $request)
    {


        return $this->update($id, $request->all());

    }

    public function components($id)
    {
        $machine = Software::find($id);
        $components = Component::where(function ($query) use ($machine) {
                $query->where('customer_id', auth()->user()->id)
                    //   ->orWhere('global', 1)
                      ->orWhere('user_id', auth()->user()->id);
                    if ($machine->customer_group_id !== null) {
                        $query->orWhere('customer_group_id', $machine->customer_group_id);
                    }
            })
            ->get();



        return $this->returnData('data', ComponentResource::collection($components), __('Get successfully'));

    }

}
