<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Http\Requests\ModulePostRequest;
use App\Repositories\FlashRepository;

class ModuleController extends Controller
{
    private $flashRepository;

    public function __construct()
    {
        $this->flashRepository = new FlashRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $module = Module::all();

            return datatables()->of($module)
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button title="Change status" class="toggle-btn btn btn-' . ($row->is_enable ? 'danger' : 'success') . ' btn-xs" data-id="' . $row->id . '" data-state="' . ($row->is_enable ? 'disabled' : 'enabled') . '">' . ($row->is_enable ? 'Disable' : 'Enable') . '</button>';
                    $btn =  $btn . '&nbsp;&nbsp; <a class="btn btn-icon  btn-warning" href="' . route('module.edit', ['module' => $row->id]) . '"><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>';                                                        ;
                    $btn = $btn . '&nbsp;&nbsp;<a class="btn btn-icon  btn-danger delete-module delete-module" data-id="'.$row->id.'" data-toggle="tooltip" title="" data-original-title="Delete"> <i class="fa fa-trash-o"></i> </a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('module.list', ['module' => new Module()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.create', ['module' => new Module()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModulePostRequest $request)
    {
        $request->validated();

        $module = Module::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        if (!$module) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'module created successfully.');
        return redirect()->route('module.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        return view('module.create', ['module' => $module]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(ModulePostRequest $request, Module $module)
    {
        $request->validated();

        $module = Module::find($module->id);
        $module->update(
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );
        if (!$module) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'Module updated successfully.');
        return redirect()->route('module.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module = module::find($module->id)->delete();
        if ($module) {
            return response()->json(['msg' => 'Module deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }

    public function updateStatus(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);
        $module->is_enable = $request->state === 'enabled' ? 1 : 0;
        $module->save();
        return response()->json(['message' => 'Module status toggled successfully']);
    }
}
