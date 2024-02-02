<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Http\Requests\{StoreMachineRequest, UpdateMachineRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Services\GeneratorService;


class MachineController extends Controller
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
            $machines = Machine::query();

            return DataTables::of($machines)
                ->addColumn('action', 'admin.machines.include.action')
                ->toJson();
        }

        return view('admin.machines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {

        return view('admin.machines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(StoreMachineRequest $request)
    {
        Machine::create($request->validated());

        return redirect()
            ->route('machines.index')
            ->with('success', __('The machine was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Machine  $machine
     * @return
     */
    public function show(Machine $machine)
    {
        return view('admin.machines.show', compact('machine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Machine  $machine
     * @return
     */
    public function edit(Machine $machine)
    {
        return view('admin.machines.edit', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Machine  $machine
     * @return
     */
    public function update(UpdateMachineRequest $request, Machine $machine)
    {
        $machine->update($request->validated());

        return redirect()
            ->route('machines.index')
            ->with('success', __('The machine was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Machine  $machine
     * @return
     */
    public function destroy(Machine $machine)
    {
        try {
            $machine->delete();


            return response()->json(['msg' => 'Item deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not deleted'], 500);
        }
    }
}
