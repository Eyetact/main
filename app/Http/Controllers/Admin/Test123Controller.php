<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Test123;
use App\Http\Requests\{StoreTest123Request, UpdateTest123Request};
use Yajra\DataTables\Facades\DataTables;

class Test123Controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        if (request()->ajax()) {
            $test123s = Test123::query();

            return DataTables::of($test123s)
                ->addColumn('action', 'admin.test123s.include.action')
                ->toJson();
        }

        return view('admin.test123s.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.test123s.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreTest123Request $request)
    {
        Test123::create($request->validated());

        return redirect()
            ->route('test123s.index')
            ->with('success', __('The test123 was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test123  $test123
     * @return
     */
    public function show(Test123 $test123)
    {
        return view('admin.test123s.show', compact('test123'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test123  $test123
     * @return
     */
    public function edit(Test123 $test123)
    {
        return view('admin.test123s.edit', compact('test123'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test123  $test123
     * @return
     */
    public function update(UpdateTest123Request $request, Test123 $test123)
    {
        $test123->update($request->validated());

        return redirect()
            ->route('test123s.index')
            ->with('success', __('The test123 was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test123  $test123
     * @return
     */
    public function destroy(Test123 $test123)
    {
        try {
            $test123->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
