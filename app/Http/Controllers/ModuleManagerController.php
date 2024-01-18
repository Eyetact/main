<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModulePostRequest;
use App\Models\Attribute;
use App\Models\MenuManager;
use App\Models\Module;
use App\Repositories\FlashRepository;
use App\Services\GeneratorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleManagerController extends Controller
{
    private $flashRepository;
    protected $generatorService;

    public function __construct()
    {
        $this->flashRepository = new FlashRepository;
        $this->generatorService = new GeneratorService();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $moduleData = Module::get();
        return view('module_manager.menu', ['menu' => new MenuManager(), 'data' => $data, 'moduleData' => $moduleData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  void
     */
    public function store(ModulePostRequest $request)
    {

        // try {
        //     DB::beginTransaction();
        $module = Module::create([
            'name' => $request->name,
            'is_system' => isset($request->is_system) ? 1 : 0,
            'code' => $request->code,
        ]);

        $requestData = $request->all();
        $request->validated();
        // $this->generatorService->generateModel($request->all()); // model
        // $this->generatorService->generateMigration($request->all(), $module->id); // migration
        // Artisan::call('migrate'); // run php artisan mnigrate in background
        // $this->generatorService->generateController($request->all()); // migration
        // $this->generatorService->generateRequest($request->all()); // req
        // $this->generatorService->generateRoute($request->all()); // route
        // $this->generatorService->generateViews($request->all()); // views

        if (!empty($request->fields[0])) {
            foreach ($request->fields as $i => $attr) {
                $createArr = [

                    'module' => $module->id,
                    'name' => $attr,
                    'type' => $request['column_types'][$i],
                    'min_length' => $request['min_lengths'][$i],
                    'max_length' => $request['max_lengths'][$i],
                    'steps' => $request['steps'][$i],
                    'input' => $request['input_types'][$i],
                    'required' => $request['requireds'][$i],
                    'default_value' => $request['default_values'][$i],
                    'select_option' => $request['select_options'][$i],
                    'constrain' => $request['constrains'][$i],
                    'on_update_foreign' => $request['on_update_foreign'][$i],
                    'on_delete_foreign' => $request['on_delete_foreign'][$i],
                    'is_enable' => isset($request['is_enable'][$i]) ? 1 : 0,
                    'is_system' => isset($request['is_system'][$i]) ? 1 : 0,
                    'max_size' => $request['files_sizes'][$i],
                    'file_type' => $request['file_types'][$i],

                ];

                // dd($createArr);
                $attribute = Attribute::create($createArr);
            }
        }

        if ($module) {
            $lastSequenceData = MenuManager::where('parent', '0')->where('menu_type', $requestData['menu_type'])->where('include_in_menu', 1)->orderBy('id', 'desc')->first();
            $sequence = 0;
            if ($lastSequenceData) {
                $sequence = $lastSequenceData->sequence + 1;
            }

            $createData = array(
                'name' => $requestData['name'],
                'module_id' => $module->id,
                'include_in_menu' => (isset($requestData['include_in_menu']) ?? 0),
                'menu_type' => $requestData['menu_type'],
                'path' => str_replace(' ', '', $requestData['path']),
                'sequence' => $sequence,
                'parent' => 0,
                'sidebar_name' => $requestData['sidebar_name'],
            );
            $menuManager = MenuManager::create($createData);
        }

        if (!$menuManager) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module_manager.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'Menu Item created successfully.');
        return redirect()->route('module_manager.index');

        //     DB::commit();
        // } catch (Exception $ex) {
        //     DB::rollback();
        //     dd($ex);
        // }

    }

    private function pluralize($singular)
    {
        $plural = array(
            '/(quiz)$/i' => '$1zes',
            '/^(ox)$/i' => '$1en',
            '/([m|l])ouse$/i' => '$1ice',
            '/(matr|vert|ind)ix|ex$/i' => '$1ices',
            '/(x|ch|ss|sh)$/i' => '$1es',
            '/([^aeiouy]|qu)ies$/i' => '$1y',
            '/([^aeiouy]|qu)y$/i' => '$1ies',
            '/(hive)$/i' => '$1s',
            '/(?:([^f])fe|([lr])f)$/i' => '$1$2ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '$1a',
            '/(buffal|tomat)o$/i' => '$1oes',
            '/(bu)s$/i' => '$1ses',
            '/(alias|status)$/i' => '$1es',
            '/(octop)us$/i' => '$1i',
            '/(ax|test)is$/i' => '$1es',
            '/s$/i' => 's',
            '/$/' => 's',
        );

        foreach ($plural as $pattern => $replacement) {
            if (preg_match($pattern, $singular)) {
                return preg_replace($pattern, $replacement, $singular);
            }
        }

        return $singular;
    }

    private function generateMigrationContent($tableName)
    {
        // Define the migration schema here based on $tableName
        $content = <<<EOT
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class Create{$tableName}Table extends Migration
        {
            public function up()
            {
                Schema::create('$tableName', function (Blueprint \$table) {
                    \$table->id();
                    \$table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('$tableName');
            }
        }
        EOT;

        return $content;
    }

    private function generateMigrationContentforRename($newTable, $oldTable)
    {
        // Define the migration schema here based on $newTable
        $content = <<<EOT
        <?php
        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::rename('$oldTable', '$newTable');
            }

            public function down()
            {
                Schema::rename('$newTable', '$oldTable');
            }
        };
        EOT;

        return $content;
    }

    public function menu_update(Request $request)
    {
        // dd($request);
        if ($request->type == 'storfront') {
            $dataArray = json_decode($request['storfront_json'], true);
        } else {
            $dataArray = json_decode($request['admin_json'], true);
        }
        // dd($request->all(),$dataArray);
        $data = $this->processArray($dataArray);

        return response()->json(['success' => true]);
    }

    public function processArray($dataArray)
    {
        foreach ($dataArray as $item) {
            $data = MenuManager::find($item['id']);
            $data->sequence = $item['sequence'];
            $data->parent = $item['parent'];
            $data->save();
            // Check if there are children and recursively process them
            if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
                $this->processArray($item['children']);
            }
        }
    }

    public function update(Request $request, $id)
    {

        $module = Module::find($id);

        if (!empty($request->name)):
            $module->update(
                [
                    'name' => $request->name,
                ]
            );

            $menu = MenuManager::where('module_id', $module->id)->first();
            $menu->update(
                [
                    'name' => $request->name,
                    'sidebar_name' => $request->sidebar_name,
                ]
            );
        endif;

        if (!$module) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module_manager.index');
        }

        $this->generatorService->reGenerateModel($request['module']);
        $this->generatorService->reGenerateMigration($request['module']);
        $this->generatorService->reGenerateController($request['module']);
        $this->generatorService->reGenerateRequest($request['module']);
        $this->generatorService->reGenerateViews($request['module']);

        $this->flashRepository->setFlashSession('alert-success', 'Module updated successfully.');
        return redirect()->route('module_manager.index');
    }

    private function generateMigrationContentforDelete($table)
    {
        // Define the migration schema here based on $newTable
        $content = <<<EOT
        <?php
        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::dropIfExists('$table');
            }

            public function down()
            {
            }
        };
        EOT;

        return $content;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $migrationName = "delete_" . strtolower($module->name) . "_table";
        $modelClassName = Str::studly($module->name);
        // Create the migration
        Artisan::call('make:migration', [
            'name' => $migrationName,
        ]);

        $migrationFilePath = database_path("migrations") . "/" . date('Y_m_d_His') . "_$migrationName.php";
        File::put($migrationFilePath, $this->generateMigrationContentforDelete(strtolower($module->name)));

        Artisan::call('migrate');
        $module = Module::find($module->id)->delete();
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

    public function menuDelete(Request $request)
    {
        $menuManager = MenuManager::find($request->menu_id);
        if ($menuManager) {
            $menuManager->is_deleted = $request->is_deleted;
            $menuManager->deleted_at = $request->is_deleted == 1 ? Carbon::now()->format('Y-m-d H:i:s') : null;
            $menuManager->save();
            if ($request->is_deleted == 1) {
                $message = 'Menu Temperory Deleted successfully, You can restore within 30 days.';
            } else {
                $message = 'Menu Restored successfully.';
            }
            return response()->json(['is_deleted' => $menuManager->is_deleted, 'message' => $message], 200);
        } else {
            return response()->json(['message' => 'Menu not found.'], 200);
        }
    }

    public function edit(Module $module)
    {

        return view('module_manager.menu-edit', compact('module'));
    }
}
