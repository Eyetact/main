<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\Category;
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
        $this->repositry =  new Repository($this->model);
    }

    public function save( Request $request ){

        $model = $this->repositry->save($request->all());
        $model->user_id = auth()->user()->id;
        $model->save();


        if ($model) {
            return $this->returnData( 'data' , new $this->resource( $model ), __('Succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to create !'));
    }

    public function edit($id,Request $request){


        return $this->update($id,$request->all());

    }

    public function categories($id)
    {
        $machine=Software::find($id);
        $categories = Category::where('customer_id',auth()->user()->id)
                              ->orWhere('customer_group_id',$machine->customer_group_id)
                              ->orWhere('user_id',auth()->user()->id)
                              ->get();



        return $this->returnData('data',  CategoryResource::collection($categories), __('Get successfully'));

    }

}
