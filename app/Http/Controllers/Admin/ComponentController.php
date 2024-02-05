<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Http\Requests\{StoreComponentRequest, UpdateComponentRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Services\GeneratorService;


class ComponentController extends Controller
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
            $components = Component::query();

            return DataTables::of($components)
                ->addColumn('component_id', function($row){
                    return str($row->component_id)->limit(200);
                })
				->addColumn('component_name', function($row){
                    return str($row->component_name)->limit(200);
                })
				->addColumn('action', 'admin.components.include.action')
                ->toJson();
        }

        return view('admin.components.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {

        return view('admin.components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreComponentRequest $request)
    {
        Component::create($request->validated());

        return redirect()
            ->route('components.index')
            ->with('success', __('The component was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return
     */
    public function show(Component $component)
    {
        return view('admin.components.show', compact('component'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return
     */
    public function edit(Component $component)
    {
        return view('admin.components.edit', compact('component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component  $component
     * @return
     */
    public function update(UpdateComponentRequest $request, Component $component)
    {
        $component->update($request->validated());

        return redirect()
            ->route('components.index')
            ->with('success', __('The component was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component  $component
     * @return
     */
    public function destroy(Component $component)
    {
        try {
            $component->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
