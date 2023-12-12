<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuManager;
use App\Models\Module;
use App\Http\Requests\ModulePostRequest;
use App\Repositories\FlashRepository;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class ModuleManagerController extends Controller
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
        $data=array();
        $moduleData=Module::get();
        return view('module_manager.menu', ['menu' => new MenuManager(), 'data' => $data,'moduleData'=>$moduleData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModulePostRequest $request)
    {
        // dd($request->all());
        $requestData=$request->all();

        $request->validated();
        $pluralWord = $this->pluralize($requestData['name']);

        $migrationName = "create_" . strtolower(str_replace(' ', '', $pluralWord)) . "_table";
        $modelClassName = Str::studly(str_replace(' ', '', $pluralWord));

        // // Create the migration
        // Artisan::call('make:migration', [
        //     'name' => $migrationName,
        //     '--create' => strtolower(str_replace(' ', '', $pluralWord)),
        // ]);

        // Log::info('Migration created: '.$migrationName);

        $migrationFilePath = database_path("migrations") . "/" . date('Y_m_d_His') . "_$migrationName.php";

        // // Check if the file exists
        // if (File::exists($migrationFilePath)) {
        //     Log::info('migration exist');
        //     // File exists, append the content
        //     File::append($migrationFilePath, $this->generateMigrationContent(str_replace(' ', '', $pluralWord)));
        // } else {
            Log::info('migration not exist');
            // File doesn't exist, create it and write the content
            File::put($migrationFilePath, $this->generateMigrationContent(str_replace(' ', '', $pluralWord)));
        // }

        // File::put($migrationFilePath, $this->generateMigrationContent(str_replace(' ', '', $pluralWord)));

        // Create the model
        Artisan::call('make:model', [
            'name' => str_replace(' ', '', $request->name),
        ]);

        Artisan::call('migrate');

        $module = Module::create([
            'name' => $request->name
        ]);

        if($module){
            $lastSequenceData=MenuManager::where('parent','0')->where('menu_type',$requestData['menu_type'])->where('include_in_menu',1)->where('status',1)->orderBy('id','desc')->first();
            $sequence=0;
            if($lastSequenceData){
                $sequence=$lastSequenceData->sequence+1;
            }

            $createData=array(
                'name' => $requestData['name'],
                'module_id' => $module->id,
                'status'=> (isset($requestData['is_enable']) ?? 0),
                'include_in_menu'=> (isset($requestData['include_in_menu']) ?? 0),
                'menu_type' => $requestData['menu_type'],
                'code' => str_replace(' ', '', $requestData['code']),
                'path' => str_replace(' ', '', $requestData['path']),
                'meta_title' => (isset($requestData['meta_title']) ?? ''),
                'meta_description' => (isset($requestData['meta_description']) ?? ''),
                'assigned_attributes' => $requestData['assigned_attributes'],
                'sequence' => $sequence,
                'parent' => 0,
                'created_date' => date('Y-m-d',strtotime($requestData['created_date']))
            );
            // dd($createData);
            $menuManager = MenuManager::create($createData);
        }

        if (!$menuManager) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module_manager.index');
        }
        $this->flashRepository->setFlashSession('alert-success', 'Menu Item created successfully.');
        return redirect()->route('module_manager.index');
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
            '/$/' => 's'
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

    public function menu_update(Request $request){
        // dd($request);
        if($request->type=='storfront'){
            $dataArray = json_decode($request['storfront_json'], true);
        }else{
            $dataArray = json_decode($request['admin_json'], true);
        }
        // dd($request->all(),$dataArray);
        $data=$this->processArray($dataArray);

        return response()->json(['success' => true]);
    }

    public function processArray($dataArray) {
        foreach ($dataArray as $item) {
            $data=MenuManager::find($item['id']);
            $data->sequence=$item['sequence'];
            $data->parent=$item['parent'];
            $data->save();
            // Check if there are children and recursively process them
            if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
                $this->processArray($item['children']);
            }
        }
    }

    public function update(ModulePostRequest $request,$id)
    {
        // dump($request->all());
        $request->validated();

        $requestData=$request->all();

        $menuData=MenuManager::find($id);
        // dump($menuData->toArray());

        $module = Module::find($menuData->module_id);
        $oldName = $menuData->name;
        if ($oldName !== $request->name) {
            $pluralWord = str_replace(' ', '', $this->pluralize($request->name));
            $moduleName = str_replace(' ', '', $this->pluralize($module->name));

            $migrationName = "rename_" . strtolower($moduleName) . "_table";
            $modelClassName = Str::studly($pluralWord);

            $migrationFilePath = database_path("migrations") . "/" . date('Y_m_d_His') . "_$migrationName.php";

            File::put($migrationFilePath, $this->generateMigrationContentforRename(strtolower($pluralWord), strtolower($moduleName)));

            // Create the model
            Artisan::call('make:model', [
                'name' => str_replace(' ', '', $request->name),
            ]);
            Artisan::call('migrate');
        }

        $module->update(
            [
                'name' => $request->name
            ]
        );
        if (!$module) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!.');
            return redirect()->route('module.index');
        }

        $updateData=array(
            'name' => $requestData['name'],
            'status'=> (isset($requestData['is_enable']) ?? 0),
            'include_in_menu'=> (isset($requestData['include_in_menu']) ?? 0),
            'menu_type' => $requestData['menu_type'],
            'code' => str_replace(' ', '', $requestData['code']),
            'path' => str_replace(' ', '', $requestData['path']),
            'meta_title' => (isset($requestData['meta_title']) ?? ''),
            'meta_description' => (isset($requestData['meta_description']) ?? ''),
            'assigned_attributes' => $requestData['assigned_attributes'],
            'created_date' => date('Y-m-d',strtotime($requestData['created_date']))
        );
        dd($updateData);

        $this->flashRepository->setFlashSession('alert-success', 'Module updated successfully.');
        return redirect()->route('module.index');
    }

    private function generateMigrationContentforDelete($table){
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
            'name' => $migrationName
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
        if($menuManager){
            $menuManager->is_deleted = $request->is_deleted;
            $menuManager->deleted_at = $request->is_deleted == 1 ? Carbon::now()->format('Y-m-d H:i:s') : null;
            $menuManager->save();
            if($request->is_deleted == 1){
                $message = 'Menu Temperory Deleted successfully, You can restore within 30 days.';
            }else{
                $message = 'Menu Restored successfully.';
            }
            return response()->json(['is_deleted' => $menuManager->is_deleted,'message' => $message], 200);
        }else{
            return response()->json(['message' => 'Menu not found.'], 200);
        }
    }
}
