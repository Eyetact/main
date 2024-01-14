<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testdd;
use App\Http\Requests\{StoreTestddRequest, UpdateTestddRequest};
use Yajra\DataTables\Facades\DataTables;

class TestddController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        if (request()->ajax()) {
            $testdds = Testdd::query();

            return DataTables::of($testdds)
                ->addColumn('action', 'admin.testdds.include.action')
                ->toJson();
        }

        return view('admin.testdds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.testdds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreTestddRequest $request)
    {
        Testdd::create($request->validated());

        return redirect()
            ->route('testdds.index')
            ->with('success', __('The testdd was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testdd  $testdd
     * @return
     */
    public function show(Testdd $testdd)
    {
        return view('admin.testdds.show', compact('testdd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testdd  $testdd
     * @return
     */
    public function edit(Testdd $testdd)
    {
        return view('admin.testdds.edit', compact('testdd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testdd  $testdd
     * @return
     */
    public function update(UpdateTestddRequest $request, Testdd $testdd)
    {
        $testdd->update($request->validated());

        return redirect()
            ->route('testdds.index')
            ->with('success', __('The testdd was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testdd  $testdd
     * @return
     */
    public function destroy(Testdd $testdd)
    {
        try {
            $testdd->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
