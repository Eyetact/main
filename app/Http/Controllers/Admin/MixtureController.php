<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Mixture;
use App\Http\Requests\{StoreMixtureRequest, UpdateMixtureRequest};
use Yajra\DataTables\Facades\DataTables;

class MixtureController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        if (request()->ajax()) {
            $mixtures = Mixture::query();

            return DataTables::of($mixtures)
                ->addColumn('action', 'admin.mixtures.include.action')
                ->toJson();
        }

        return view('admin.mixtures.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.mixtures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreMixtureRequest $request)
    {
        Mixture::create($request->validated());

        return redirect()
            ->route('mixtures.index')
            ->with('success', __('The mixture was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mixture  $mixture
     * @return
     */
    public function show(Mixture $mixture)
    {
        return view('admin.mixtures.show', compact('mixture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mixture  $mixture
     * @return
     */
    public function edit(Mixture $mixture)
    {
        return view('admin.mixtures.edit', compact('mixture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mixture  $mixture
     * @return
     */
    public function update(UpdateMixtureRequest $request, Mixture $mixture)
    {
        $mixture->update($request->validated());

        return redirect()
            ->route('mixtures.index')
            ->with('success', __('The mixture was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mixture  $mixture
     * @return
     */
    public function destroy(Mixture $mixture)
    {
        try {
            $mixture->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
