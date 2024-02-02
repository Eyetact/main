<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Http\Requests\{StoreTestRequest, UpdateTestRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Services\GeneratorService;


class TestController extends Controller
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
            $tests = Test::with('material:id,material_name');

            return DataTables::of($tests)
                ->addColumn('material', function ($row) {
                    return $row->material ? $row->material->material_name : '';
                })->addColumn('action', 'admin.tests.include.action')
                ->toJson();
        }

        return view('admin.tests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {

        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreTestRequest $request)
    {
        Test::create($request->validated());

        return redirect()
            ->route('tests.index')
            ->with('success', __('The test was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return
     */
    public function show(Test $test)
    {
        $test->load('material:id,material_name');

		return view('admin.tests.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return
     */
    public function edit(Test $test)
    {
        $test->load('material:id,material_name');

		return view('admin.tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return
     */
    public function update(UpdateTestRequest $request, Test $test)
    {
        $test->update($request->validated());

        return redirect()
            ->route('tests.index')
            ->with('success', __('The test was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return
     */
    public function destroy(Test $test)
    {
        try {
            $test->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
