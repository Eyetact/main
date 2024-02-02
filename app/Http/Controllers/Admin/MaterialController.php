<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Http\Requests\{StoreMaterialRequest, UpdateMaterialRequest};
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        if (request()->ajax()) {
            $materials = Material::query();

            return DataTables::of($materials)
                ->addColumn('material_name', function($row){
                    return str($row->material_name)->limit(200);
                })
				->addColumn('material_id', function($row){
                    return str($row->material_id)->limit(200);
                })
				->addColumn('action', 'admin.materials.include.action')
                ->toJson();
        }

        return view('admin.materials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreMaterialRequest $request)
    {
        Material::create($request->validated());

        return redirect()
            ->route('materials.index')
            ->with('success', __('The material was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return
     */
    public function show(Material $material)
    {
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return
     */
    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return redirect()
            ->route('materials.index')
            ->with('success', __('The material was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
