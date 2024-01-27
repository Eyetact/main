<?php

namespace App\Http\Controllers;

use App\Models\Multi;
use App\Services\GeneratorService;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Module;
use App\Http\Requests\AttributePostRequest;
use App\Repositories\FlashRepository;

class AttributeController extends Controller
{
    private $flashRepository;
    private $generatorService;

    public function __construct()
    {
        $this->flashRepository = new FlashRepository;
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
            $attribute = Attribute::all();

            return datatables()->of($attribute)
                ->addColumn('module', function ($row) {
                    return $row->moduleObj->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
            <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">


                <li class="dropdown-item">
                <a class="delete-attribute" href="#" data-id="' . $row->id . '" class="attribute-delete">Delete</a>
                </li>
            </ul>
        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])

                ->addIndexColumn()
                ->make(true);
        }
        $all = Module::all();
        $options = '';
        foreach ($all as $key => $value) {
            $options .= '<option value="' . $value->name . '" >' . $value->name . '</option>';
        }

        return view('attribute.list', ['attribute' => new Attribute(), 'all' => $options]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return 
     */
    public function create()
    {
        $moduleData = Module::where('migration', '!=', NULL)->get();
        $all = Module::all();
        return view('attribute.create', ['attribute' => new Attribute(), 'moduleData' => $moduleData, 'all' => $all]);
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
        $requestData = $request->all();

        $attr = Attribute::where('name', $request['name'])->where('module', $request['module'])->first();
        if ($attr) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('attribute.index');
        }
        $enumValues = '';
        if (isset($request['fields_info'])) {
            $count = count($request['fields_info']);
            foreach ($request['fields_info'] as $key => $value) {
                if ($value['default'] == 1) {
                    $request['default_values'] = $value['value'];
                }
                if ($key == $count) {

                    $enumValues .= $value['value'];
                } else {

                    $enumValues .= $value['value'] . '|';
                }

            }

            $request['select_options'] = $enumValues;

        }

        // dd($request);

        $createArr = [

            'module' => $request['module'],
            'name' => str(str_replace('.','',$request['name']))->lower(),
            'type' => $request['column_types'],
            'min_length' => $request['min_lengths'],
            'max_length' => $request['max_lengths'],
            'steps' => $request['steps'],
            'input' => $request['input_types'],
            'required' => isset($request['requireds']) ? 'yes' : 'no',
            'default_value' => $request['default_values'],
            'select_option' => $request['select_options'],
            'constrain' => $request['constrains'],
            'on_update_foreign' => $request['on_update_foreign'],
            'on_delete_foreign' => $request['on_delete_foreign'],
            'is_enable' => isset($request['is_enable']) ? 1 : 0,
            'is_system' => isset($request['is_system']) ? 1 : 0,
            'max_size' => $request['files_sizes'],
            'file_type' => $request['file_types'],
        ];

        // dd($createArr);
        $attribute = Attribute::create($createArr);

        if (isset($requestData['multi'])) {

            foreach ($requestData['multi'] as $key => $value) {
                $m = new Multi();
                $m->name = str()->snake(str_replace('.','',$value['name']))->lower();
                $m->type = $value['type'];
                $m->select_options = isset($value['select_options']) ? $value['select_options'] : '';
                $m->attribute_id = $attribute->id;
                $m->save();
            }
        }

        $this->generatorService->reGenerateModel($request['module']);
        $this->generatorService->reGenerateMigration($request['module']);
        $this->generatorService->reGenerateController($request['module']);
        $this->generatorService->reGenerateRequest($request['module']);
        $this->generatorService->reGenerateViews($request['module']);

        // dd($requestData['multi']);

        if (!$attribute) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('attribute.index');
        }

        $this->flashRepository->setFlashSession('alert-success', 'Attribute created successfully.');
        return redirect()->route('attribute.index');
    }

    public function test($id)
    {
        $this->generatorService->reGenerateViews($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $moduleData = Module::active()->get();
        return view('attribute.create', ['attribute' => $attribute, 'moduleData' => $moduleData]);
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

        $requestData = $request->all();

        // dump($requestData);

        $fields_info = $requestData['fields_info'];
        if ($requestData['field_type'] == 'select' && $requestData['field_type'] == 'multiselect' && $requestData['field_type'] == 'radio' && $requestData['field_type'] == 'checkbox') {
            $order = 1;
            $fields_info = array_map(function ($key, $arr) use (&$order) {
                if (is_array($arr)) {
                    return array_merge($arr, ['order' => $order++]);
                }
            }, array_keys($fields_info), $fields_info);
        } elseif ($requestData['field_type'] == 'text' || $requestData['field_type'] == 'file') {
            $fields_info = array_filter($fields_info, function ($element, $key) {
                return $key === 'file_ext' || !is_array($element);
            }, ARRAY_FILTER_USE_BOTH);
        } else {
            $fields_info = [];
        }
        // dump($fields_info);
        $updateArr = [
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
        $attribute = Attribute::find($attribute->id);
        $id = $attribute->module;
        if ($attribute) {
            $this->generatorService->removeMigration($id, $attribute->id);
            $attribute->delete();
            $this->generatorService->reGenerateModel($id);
            $this->generatorService->reGenerateController($id);
            $this->generatorService->reGenerateRequest($id);
            $this->generatorService->reGenerateViews($id);

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
