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
use App\Http\Resources\ComponentSetResource;

class ComponentSetController extends ApiController
{
    public function __construct()
    {
        $this->resource = ComponentSetResource::class;
        $this->model = app(ComponentsSet::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {

        $machine = Software::find($request->machine_id);

        $model = new ComponentsSet();
        $model->compo_set_name = $request->name;
        $model->main_part_id = $machine->main_part_id;

        $decodedComponents = is_array($request->set_component) ? $request->set_component : json_decode($request->set_component, true);
        if (!is_array($decodedComponents)) {
            return $this->returnError(__('Invalid set_component data.'));
        }

        $setComponents = [];
        $index = 1;
        foreach ($decodedComponents as $item) {
            if (!isset($item['name'])) {
                return $this->returnError(__('Invalid component name.'));
            }

            $setComponents[$index] = [
                'name' => $item['name'],
            ];
            $index++;
        }

        // $encodedComponents = json_encode($setComponents, JSON_UNESCAPED_UNICODE);
        // $encodedComponents = preg_replace('/\\\\/', '', $encodedComponents);

        $model->set_component = $setComponents;
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
        $components = ComponentsSet::where('main_part_id', $machine->main_part_id)
            ->where(function ($query) use ($machine) {
                $query->where('customer_id', auth()->user()->id)
                    ->orWhere('customer_group_id', optional($machine)->customer_group_id)
                    ->orWhere('user_id', auth()->user()->id);
            })
            ->get();



        return $this->returnData('data', ComponentSetResource::collection($components), __('Get successfully'));

    }

}
