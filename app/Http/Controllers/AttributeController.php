<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Module;
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
        return view('attribute.list', ['attribute' => new Attribute()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moduleData=Module::get();
        return view('attribute.create', ['attribute' => new Attribute(),'moduleData'=>$moduleData]);
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
        $requestData=$request->all();
        // dd($requestData);
        $fields_info=$requestData['fields_info'];
        if($requestData['field_type']=='select' && $requestData['field_type']=='multiselect' && $requestData['field_type']=='radio' && $requestData['field_type']=='checkbox'){
            $order = 1;
            $fields_info = array_map(function ($key, $arr) use (&$order) {
                if (is_array($arr)) {
                    return array_merge($arr, ['order' => $order++]);
                }
            }, array_keys($fields_info), $fields_info);
        } elseif ($requestData['field_type']=='text' || $requestData['field_type']=='file') {
            $fields_info = array_filter($fields_info, function ($element,$key) {
                return $key === 'file_ext' || !is_array($element);
            }, ARRAY_FILTER_USE_BOTH);
        } else {
            $fields_info = [];
        }
        // dd($fields_info);
        $createArr=[
            'module' => $requestData['module'],
            'name' => $requestData['name'],
            'field_type' => $requestData['field_type'],
            'input_name' => $requestData['input_name'],
            'input_class' => $requestData['input_class'],
            'input_id' => $requestData['input_id'],
            'scope' => $requestData['scope'],
            'depend' => $requestData['depend'],
            'attribute' => $requestData['attribute'],
            'validation' => $requestData['validation'],
            'is_required' => isset($requestData['is_required']) ? 1 : 0,
            'is_enable' => isset($requestData['is_enable']) ? 1 : 0,
            'is_system' => isset($requestData['is_system']) ? 1 : 0,
            'fields_info' => json_encode($fields_info),
            'description' => $requestData['description']
        ];

        // dd($createArr);
        $attribute = Attribute::create($createArr);

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
        $moduleData=Module::active()->get();
        return view('attribute.create', ['attribute' => $attribute,'moduleData' => $moduleData]);
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

        $requestData=$request->all();

        // dump($requestData);

        $fields_info=$requestData['fields_info'];
        if($requestData['field_type']=='select' && $requestData['field_type']=='multiselect' && $requestData['field_type']=='radio' && $requestData['field_type']=='checkbox'){
            $order = 1;
            $fields_info = array_map(function ($key, $arr) use (&$order) {
                if (is_array($arr)) {
                    return array_merge($arr, ['order' => $order++]);
                }
            }, array_keys($fields_info), $fields_info);
        } elseif ($requestData['field_type']=='text' || $requestData['field_type']=='file') {
            $fields_info = array_filter($fields_info, function ($element,$key) {
                return $key === 'file_ext' || !is_array($element);
            }, ARRAY_FILTER_USE_BOTH);
        } else {
            $fields_info = [];
        }
        // dump($fields_info);
        $updateArr=[
            'module' => $requestData['module'],
            'name' => $requestData['name'],
            'field_type' => $requestData['field_type'],
            'input_name' => $requestData['input_name'],
            'input_class' => $requestData['input_class'],
            'input_id' => $requestData['input_id'],
            'scope' => $requestData['scope'],
            'depend' => $requestData['depend'],
            'attribute' => $requestData['attribute'],
            'validation' => $requestData['validation'],
            'is_required' => isset($requestData['is_required']) ? 1 : 0,
            'is_enable' => isset($requestData['is_enable']) ? 1 : 0,
            'is_system' => isset($requestData['is_system']) ? 1 : 0,
            'fields_info' => json_encode($fields_info),
            'description' => $requestData['description']
        ];
        // dd($updateArr);

        $attribute = Attribute::find($attribute->id);
        $attribute->update($updateArr);

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
