<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Http\Requests\Admin\{StoreProductRequest, UpdateProductRequest};
use App\Models\UCGroup;
use App\Models\Attribute;
use Yajra\DataTables\Facades\DataTables;
use App\Services\GeneratorService;
use App\Models\Module;
use App\Generators\GeneratorUtils;




class ProductController extends Controller
{
    private $generatorService;

    public function __construct()
    {
        $this->generatorService = new GeneratorService();

    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {



        if (request()->ajax()) {
            $products = Product::query();

               if (auth()->user()->access_table == "Group") {
                $group_ids = auth()->user()->groups()->pluck('group_id');

                $userids= UCGroup::whereIn('group_id', $group_ids)
                ->pluck('user_id');



                $products = Product::whereIn('user_id', $userids)->get();
            }

            if (auth()->user()->access_table == "Individual") {

                $products = Product::where('user_id', auth()->user()->id)->get();

            }

            return DataTables::of($products)
                ->addColumn('action', 'admin.products.include.action')
                ->toJson();
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {

        return view('admin.products.create');
    }


    public function createLess()
    {

        return view('admin.products.create-less');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreProductRequest $request)
    {
        $insert = Product::create($request->validated());

        if( !empty($request->module) ){

            $module = Module::find($request->module);
            $modelName = "App\Models\Admin\\".GeneratorUtils::setModelName($module->code);

            $data = new $modelName();
            foreach ($module->fields as $value) {

                $attr = GeneratorUtils::singularSnakeCase($value->code);

                $data->$attr = $request[$attr];
            }
            $data->save();

             $insert->sub_id = $request->module;
              $insert->data_id = $data->id;
            $insert->save();

        }

        $parent_id = Module::where('code','LIKE', '%' . 'Product' . '%' )->first()->parent_id;
        if($parent_id == 0){
            return redirect()
            ->route('products.index')
            ->with('success', __('The product was created successfully.'));
        }else{
            $parent = Module::find($parent_id);
            $parent = GeneratorUtils::cleanPluralLowerCase($parent->code);
            if(!empty($parent->migration)){
            // dd($parent);
            return redirect()
                ->route($parent.'.index')
                ->with('success', __('The product  was created successfully.'));
            }
             return redirect()
            ->route('products.index')
            ->with('success', __('The product was created successfully.'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return
     */


     public function show(Product $product )
    {


          if($product->sub_id)
          {
        $module = Module::find($product->sub_id);
        $modelName = "App\Models\Admin\\".GeneratorUtils::setModelName($module->code);
        $child =  $modelName::find($product->data_id);


        return view('admin.products.show', compact('product','module','child'));
          }


        return view('admin.products.show', compact('product'));
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

     public function editLess($id)
    {

        $product = Product::find($id);
        return view('admin.products.edit-less', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());


        if( !empty($request->module) ){

            $module = Module::find($request->module);
            $modelName = "App\Models\Admin\\".GeneratorUtils::setModelName($module->code);

                      if($request->module == $product->sub_id)
                      {

            $data =  $modelName::find($product->data_id);
            foreach ($module->fields as $value) {

                $attr =  GeneratorUtils::singularSnakeCase($value->code);

                $data->$attr = $request[$attr];
            }
            $data->save();
                      }

                      else{

                           $data = new $modelName();
            foreach ($module->fields as $value) {

                $attr =  GeneratorUtils::singularSnakeCase($value->code);

                $data->$attr = $request[$attr];
            }
            $data->save();

             $product->sub_id = $request->module;
              $product->data_id = $data->id;
            $product->save();

                      }


        }

             $parent_id = Module::where('code','LIKE', '%' . 'Product' . '%' )->first()->parent_id;
        if($parent_id == 0){
            return redirect()
            ->route('products.index')
            ->with('success', __('The product was updated successfully.'));
        }else{
            $parent = Module::find($parent_id);
            $parent = GeneratorUtils::cleanPluralLowerCase($parent->code);
            // dd($parent);
            if(!empty($parent->migration)){
         return redirect()
            ->route('products.index')
            ->with('success', __('The product was updated successfully.'));
            }
             return redirect()
            ->route('products.index')
            ->with('success', __('The product was updated successfully.'));

        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return
     */
    public function destroy(Product $product)
    {
        try {


            if($product->sub_id)
            {

            $module = Module::find($product->sub_id);
            $modelName = "App\Models\Admin\\".GeneratorUtils::setModelName($module->code);
            $child =  $modelName::find($product->data_id);
            $child->delete();
            }

            $product->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
