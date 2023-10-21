<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Http\Requests\AttributePostRequest;
use App\Repositories\FlashRepository;

class AttributeController extends Controller
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
            $attribute = Attribute::all();

            return datatables()->of($attribute)
                ->addColumn('action', 'company-action')
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button title="Change status" class="toggle-btn btn btn-' . ($row->is_enable ? 'danger' : 'success') . ' btn-xs" data-id="' . $row->id . '" data-state="' . ($row->is_enable ? 'disabled' : 'enabled') . '">' . ($row->is_enable ? 'Disable' : 'Enable') . '</button>';
                    $btn =  $btn . '&nbsp;&nbsp; <a class="btn btn-icon  btn-warning" href="' . route('attribute.edit', ['attribute' => $row->id]) . '"><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>';                                                        ;
                    $btn = $btn . '&nbsp;&nbsp;<a class="btn btn-icon  btn-danger delete-attribute delete-attribute" data-id="'.$row->id.'" data-toggle="tooltip" title="" data-original-title="Delete"> <i class="fa fa-trash-o"></i> </a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('attributes.list', ['attribute' => new Attribute()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attributes.create', ['attribute' => new Attribute()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributePostRequest $request)
    {
        $request->validated();

        $attribute = Attribute::create([
            'name' => $request->name,
            'field_type' => $request->field_type,
            'input_name' => $request->input_name,
            'input_class' => $request->input_class,
            'input_id' => $request->input_id,
            'is_required' => isset($request->is_required) ? 1 : 0,
            'validation_message' => $request->validation_message,
            'fields_info' => json_encode($request->fields_info),
            'description' => $request->description
        ]);
        if (!$attribute) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('attribute.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'Attribute created successfully.');
        return redirect()->route('attribute.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('attributes.create', ['attribute' => $attribute]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributePostRequest $request, Attribute $attribute)
    {
        $request->validated();

        $attribute = Attribute::find($attribute->id);
        $attribute->update(
            [
                'name' => $request->name,
                'field_type' => $request->field_type,
                'input_name' => $request->input_name,
                'input_class' => $request->input_class,
                'input_id' => $request->input_id,
                'is_required' => isset($request->is_required) ? 1 : 0,
                'validation_message' => $request->validation_message,
                'fields_info' => json_encode($request->fields_info),
                'description' => $request->description
            ]
        );
        if (!$attribute) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('attribute.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'Attribute updated successfully.');
        return redirect()->route('attribute.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute = Attribute::find($attribute->id)->delete();
        if ($attribute) {
            return response()->json(['msg' => 'Attribute deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }

    public function updateStatus(Request $request, $attributeId)
    {
        $attribute = Attribute::findOrFail($attributeId);
        $attribute->is_enable = $request->state === 'enabled' ? 1 : 0;
        $attribute->save();
        return response()->json(['message' => 'Attribute status toggled successfully']);
    }
}
