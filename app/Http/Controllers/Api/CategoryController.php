<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ComponentResource;
use App\Http\Resources\MixtureDataResource;
use App\Http\Resources\MixtureResource;
use App\Models\Admin\Category;
use App\Models\Admin\Classification;
use App\Models\Admin\Component;
use App\Models\Admin\ComponentsSet;
use App\Models\Admin\Mixture;
use App\Models\Admin\Software;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;


class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->resource = CategoryResource::class;
        $this->model = app(Category::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {

        $classification = new Classification();
        $classification->class_child = $request->name;
        $classification->save();

        $model = $this->repositry->save($request->all());
        $model->classification_id = $classification->id;
        $model->user_id = auth()->user()->id;

        $model->save();



        if ($model) {
            return $this->returnData('data', new $this->resource($model), __('Succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to create !'));
    }

    public function edit($id, Request $request)
    {


        $model = Category::find($id);


        if ($model) {

            $classification = Classification::find($model->classification_id);
            $classification->class_child = $request->name;
            $classification->save();

            return $this->returnData('data', new $this->resource($model), __('Succesfully'));
        }

        return $this->returnError(__('Sorry! Category Not Found !'));
    }



    public function categories($id)
    {
        $machine = Software::find($id);

        $categories = Category::where(function ($query) use ($machine) {
            $query->where('customer_id', auth()->user()->id)
                ->orWhere('user_id', auth()->user()->id);
            // ->orWhere('global', 1);

            if ($machine->customer_group_id !== null) {
                $query->orWhere('customer_group_id', $machine->customer_group_id);
            }
        })
            ->get();
            // dd($categories);


        return $this->returnData('data', CategoryResource::collection($categories), __('Get successfully'));

    }



    public function myLists(Request $request)
    {

        if ($request->name == "categories") {

            $machine = Software::find($request->machine_id);

            $components_set = ComponentsSet::find($machine->components_set_id);

            if( $components_set){

            $set_component = json_decode($components_set->set_component);
            $categoryIds = collect($set_component)->pluck('id');
            // dd($categoryIds);
            $categories = collect([]);

            foreach ($categoryIds as $categoryId) {
                $component = Component::find($categoryId);
                $compo_category = json_decode($component->compo_category, true);
                $compo_category_collection = collect($compo_category)->pluck('id');

                foreach ($compo_category_collection as $categoryId) {
                    $category = Category::find($categoryId);
                    if ($category && !$categories->contains('id', $category->id)) {
                        $categories->push($category);
                    }
                }

            }

        }
                // dd($categories);


            return $this->returnData('data',  CategoryResource::collection($categories), __('Get successfully'));
        }
        if ($request->name == "components") {


            $machine = Software::find($request->machine_id);
            $components_set = ComponentsSet::find($machine->components_set_id);


            if( $components_set){
            $set_component = json_decode($components_set->set_component);
            $componentIds = collect($set_component)->pluck("id");

            $components = collect([]);

            foreach ($componentIds as $componentId) {
                $component = Component::find($componentId);
                if ($component) {
                    $components->push($component);
                }
            }


        }

            return $this->returnData('data', ComponentResource::collection($components), __('Get successfully'));
        }

        if ($request->name == "mixtures") {


            $machine = Software::find($request->machine_id);
            $mixtures = $machine->mixtures;


            return $this->returnData('data', MixtureDataResource::collection($mixtures), __('Get successfully'));



        }

    }

}
