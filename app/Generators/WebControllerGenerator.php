<?php

namespace App\Generators;
use App\Models\Module;

class WebControllerGenerator
{
    /**
     * Generate a controller file.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['code'], 'default');
        $path = GeneratorUtils::getModelLocation($request['code']);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);
        $modelNamePluralCamelCase = GeneratorUtils::pluralCamelCase($model);
        $code = GeneratorUtils::setModelName($request['code'], 'default');

        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);
        $modelNameSpaceLowercase = GeneratorUtils::cleanSingularLowerCase($model);
        $modelNameSingularPascalCase = GeneratorUtils::singularPascalCase($model);

        $query = "$modelNameSingularPascalCase::query()";

        switch ($path) {
            case '':
                $namespace = "namespace App\Http\Controllers\Admin;\nuse App\Http\Controllers\Controller;";
                $requestPath = "App\Http\Requests\{Store" . $modelNameSingularPascalCase . "Request, Update" . $modelNameSingularPascalCase . "Request}";
                break;
            default:

                $namespace = "namespace App\Http\Controllers\Admin\\$path;\n\nuse App\Http\Controllers\Controller;";
                $requestPath = "App\Http\Requests\\" . $path . "\{Store" . $modelNameSingularPascalCase . "Request, Update" . $modelNameSingularPascalCase . "Request}";
                break;
        }

        $relations = "";
        $addColumns = "";
        if (!empty($request['fields'][0])) {
            if (
                in_array('text', $request['column_types']) ||
                in_array('longText', $request['column_types'])
            ) {
                $limitText = config('generator.format.limit_text') ? config('generator.format.limit_text') : 200;

                foreach ($request['column_types'] as $i => $type) {
                    if ($type == 'text' || $type == 'longText') {
                        $addColumns .= "->addColumn('" . str($request['fields'][$i])->snake() . "', function(\$row){
                    return str(\$row->" . str($request['fields'][$i])->snake() . ")->limit($limitText);
                })\n\t\t\t\t";
                    }
                }
            }

            // load the relations for create, show, and edit
            if (in_array('foreignId', $request['column_types'])) {

                $relations .= "$" . $modelNameSingularCamelCase . "->load(";

                $countForeidnId = count(array_keys($request['column_types'], 'foreignId'));

                $query = "$modelNameSingularPascalCase::with(";

                foreach ($request['constrains'] as $i => $constrain) {
                    if ($constrain != null) {
                        $constrainName = GeneratorUtils::setModelName($request['constrains'][$i]);

                        $constrainSnakeCase = GeneratorUtils::singularSnakeCase($constrainName);
                        $selectedColumns = GeneratorUtils::selectColumnAfterIdAndIdItself($constrainName);
                        $columnAfterId = GeneratorUtils::getColumnAfterId($constrainName);

                        if ($countForeidnId + 1 < $i) {
                            $relations .= "'$constrainSnakeCase:$selectedColumns', ";
                            $query .= "'$constrainSnakeCase:$selectedColumns', ";
                        } else {
                            $relations .= "'$constrainSnakeCase:$selectedColumns'";
                            $query .= "'$constrainSnakeCase:$selectedColumns'";
                        }

                        $addColumns .= "->addColumn('$constrainSnakeCase', function (\$row) {
                    return \$row->" . $constrainSnakeCase . " ? \$row->" . $constrainSnakeCase . "->$columnAfterId : '';
                })";
                    }
                }

                $query .= ")";
                $relations .= ");\n\n\t\t";

                $query = str_replace("''", "', '", $query);
                $relations = str_replace("''", "', '", $relations);
            }
        }
        $insertDataAction = $modelNameSingularPascalCase . "::create(\$request->validated());";
        $updateDataAction = "\$" . $modelNameSingularCamelCase . "->update(\$request->validated());";

        /**
         * default controller
         */
        $template = str_replace(
            [
                '{{modelNameSingularPascalCase}}',
                '{{modelNameSingularCamelCase}}',
                '{{modelNamePluralCamelCase}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSpaceLowercase}}',
                '{{loadRelation}}',
                '{{addColumns}}',
                '{{query}}',
                '{{namespace}}',
                '{{requestPath}}',
                '{{modelPath}}',
                '{{viewPath}}',
                '{{insertDataAction}}',
                '{{updateDataAction}}',
            ],
            [
                $modelNameSingularPascalCase,
                $modelNameSingularCamelCase,
                $modelNamePluralCamelCase,
                $modelNamePluralKebabCase,
                $modelNameSpaceLowercase,
                $relations,
                $addColumns,
                $query,
                $namespace,
                $requestPath,
                $path != '' ? "App\Models\\$path\\$modelNameSingularPascalCase" : "App\Models\\$modelNameSingularPascalCase",
                $path != '' ? str_replace('\\', '.', strtolower($path)) . "." : '',
                $insertDataAction,
                $updateDataAction,
            ],
            GeneratorUtils::getTemplate('controllers/controller')
        );

        /**
         * Create a controller file.
         */
        switch ($path) {
            case '':
                file_put_contents(app_path("/Http/Controllers/Admin/{$modelNameSingularPascalCase}Controller.php"), $template);
                break;
            default:
                $fullPath = app_path("/Http/Controllers/Admin/$path/");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents("$fullPath" . $modelNameSingularPascalCase . "Controller.php", $template);
                break;
        }
    }


    public function reGenerate($id)
    {
        $module = Module::find($id);
        $model = GeneratorUtils::setModelName($module->code, 'default');
        $path = GeneratorUtils::getModelLocation($module->code);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);
        $modelNamePluralCamelCase = GeneratorUtils::pluralCamelCase($model);
        $code = GeneratorUtils::setModelName($module->code, 'default');

        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);
        $modelNameSpaceLowercase = GeneratorUtils::cleanSingularLowerCase($model);
        $modelNameSingularPascalCase = GeneratorUtils::singularPascalCase($model);

        $query = "$modelNameSingularPascalCase::query()";

        switch ($path) {
            case '':
                $namespace = "namespace App\Http\Controllers\Admin;\nuse App\Http\Controllers\Controller;";
                $requestPath = "App\Http\Requests\{Store" . $modelNameSingularPascalCase . "Request, Update" . $modelNameSingularPascalCase . "Request}";
                break;
            default:

                $namespace = "namespace App\Http\Controllers\Admin\\$path;\n\nuse App\Http\Controllers\Controller;";
                $requestPath = "App\Http\Requests\\" . $path . "\{Store" . $modelNameSingularPascalCase . "Request, Update" . $modelNameSingularPascalCase . "Request}";
                break;
        }

        $relations = "";
        $addColumns = "";

            if (
                count($module->fields()->where('type','text')->get()) > 0 ||
                count($module->fields()->where('type','longtext')->get()) > 0
            ) {
                $limitText = config('generator.format.limit_text') ? config('generator.format.limit_text') : 200;

                foreach ($module->fields as $i => $field) {
                    if ($field->type == 'text' || $field->type == 'longText') {
                        $addColumns .= "->addColumn('" . str($field->code)->snake() . "', function(\$row){
                    return str(\$row->" . str($field->code)->snake() . ")->limit($limitText);
                })\n\t\t\t\t";
                    }
                }
            }

            // load the relations for create, show, and edit
            if ( count($module->fields()->where('type','foreignId')->get()) > 0) {

                $relations .= "$" . $modelNameSingularCamelCase . "->load(";

                $countForeidnId = count($module->fields()->where('type','foreignId')->get());

                $query = "$modelNameSingularPascalCase::with(";

                foreach ($module->fields as $i => $field) {
                    $field->code = GeneratorUtils::singularSnakeCase($field->code);
                    if ($field->constrain != null) {
                        $constrainName = GeneratorUtils::setModelName($field->constrain);

                        $constrainSnakeCase = GeneratorUtils::singularSnakeCase($constrainName);
                        $selectedColumns = GeneratorUtils::selectColumnAfterIdAndIdItself($constrainName);
                        $columnAfterId = GeneratorUtils::getColumnAfterId($constrainName);

                        if ($countForeidnId + 1 < $i) {
                            $relations .= "'$constrainSnakeCase:$selectedColumns', ";
                            $query .= "'$constrainSnakeCase:$selectedColumns', ";
                        } else {
                            $relations .= "'$constrainSnakeCase:$selectedColumns'";
                            $query .= "'$constrainSnakeCase:$selectedColumns'";
                        }

                        $addColumns .= "->addColumn('$constrainSnakeCase', function (\$row) {
                    return \$row->" . $constrainSnakeCase . " ? \$row->" . $constrainSnakeCase . "->$columnAfterId : '';
                })";
                    }
                }

                $query .= ")";
                $relations .= ");\n\n\t\t";

                $query = str_replace("''", "', '", $query);
                $relations = str_replace("''", "', '", $relations);
            }

        $insertDataAction = $modelNameSingularPascalCase . "::create(\$request->validated());";
        $updateDataAction = "\$" . $modelNameSingularCamelCase . "->update(\$request->validated());";

        /**
         * default controller
         */
        $template = str_replace(
            [
                '{{modelNameSingularPascalCase}}',
                '{{modelNameSingularCamelCase}}',
                '{{modelNamePluralCamelCase}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSpaceLowercase}}',
                '{{loadRelation}}',
                '{{addColumns}}',
                '{{query}}',
                '{{namespace}}',
                '{{requestPath}}',
                '{{modelPath}}',
                '{{viewPath}}',
                '{{insertDataAction}}',
                '{{updateDataAction}}',
            ],
            [
                $modelNameSingularPascalCase,
                $modelNameSingularCamelCase,
                $modelNamePluralCamelCase,
                $modelNamePluralKebabCase,
                $modelNameSpaceLowercase,
                $relations,
                $addColumns,
                $query,
                $namespace,
                $requestPath,
                $path != '' ? "App\Models\\$path\\$modelNameSingularPascalCase" : "App\Models\\$modelNameSingularPascalCase",
                $path != '' ? str_replace('\\', '.', strtolower($path)) . "." : '',
                $insertDataAction,
                $updateDataAction,
            ],
            GeneratorUtils::getTemplate('controllers/controller')
        );

        /**
         * Create a controller file.
         */
        switch ($path) {
            case '':
                file_put_contents(app_path("/Http/Controllers/Admin/{$modelNameSingularPascalCase}Controller.php"), $template);
                break;
            default:
                $fullPath = app_path("/Http/Controllers/Admin/$path/");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents("$fullPath" . $modelNameSingularPascalCase . "Controller.php", $template);
                break;
        }
    }

}
