<?php

namespace App\Generators;

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
        $model = GeneratorUtils::setModelName($request['name'], 'default');
        $path = GeneratorUtils::getModelLocation($request['name']);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);
        $modelNamePluralCamelCase = GeneratorUtils::pluralCamelCase($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);
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
