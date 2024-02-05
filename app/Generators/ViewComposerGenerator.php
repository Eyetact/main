<?php

namespace App\Generators;

use App\Models\Crud;
use App\Models\Module;
use File;
use Illuminate\Support\Facades\Schema;

class ViewComposerGenerator
{
    /**
     * Generate view composer on viewServiceProvider, if any belongsTo relation.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $template = "";

        $model = GeneratorUtils::setModelName($request['name']);
        $viewPath = GeneratorUtils::getModelLocation($request['name']);


        if (!empty($request['fields'][0])) {
            foreach ($request['column_types'] as $i => $dataType) {
                if ($dataType == 'foreignId') {
                    // remove '/' or sub folders
                    $constrainModel = GeneratorUtils::setModelName($request['constrains'][$i]);

                    $relatedModelPath = GeneratorUtils::getModelLocation($request['constrains'][$i]);
                    $table = GeneratorUtils::pluralSnakeCase($constrainModel);

                    if ($relatedModelPath != '') {
                        $relatedModelPath = "\App\Models\\$relatedModelPath\\$constrainModel";
                    } else {
                        $relatedModelPath = "\App\Models\\" . GeneratorUtils::singularPascalCase($constrainModel);
                    }

                    $allColums = Schema::getColumnListing($table);

                    if (sizeof($allColums) > 0) {
                        $fieldsSelect = "'id', '$allColums[1]'";
                    } else {
                        $fieldsSelect = "'id'";
                    }

                    if ($i > 1) {
                        $template .= "\t\t";
                    }

                    $template = str_replace(
                        [
                            '{{modelNamePluralKebabCase}}',
                            '{{constrainsPluralCamelCase}}',
                            '{{constrainsSingularPascalCase}}',
                            '{{fieldsSelect}}',
                            '{{relatedModelPath}}',
                            '{{viewPath}}',
                        ],
                        [
                            GeneratorUtils::pluralKebabCase($model),
                            GeneratorUtils::pluralCamelCase($constrainModel),
                            GeneratorUtils::singularPascalCase($constrainModel),
                            $fieldsSelect,
                            $relatedModelPath,
                            $viewPath != '' ? str_replace('\\', '.', strtolower($viewPath)) . "." : '',
                        ],
                        GeneratorUtils::getTemplate('view-composer')
                    );
                    $path = app_path('Providers/ViewServiceProvider.php');

                    $viewProviderTemplate = substr(file_get_contents($path), 0, -6) . "\n\n\t\t" . $template . "\n\t}\n}";

                    file_put_contents($path, $viewProviderTemplate);
                }
            }
        }

    }

    public function reGenerate($id)
    {
        $module = Module::find($id);
        $template = "";

        $model = GeneratorUtils::setModelName($module->name);
        $viewPath = GeneratorUtils::getModelLocation($module->name);


        foreach ($module->fields as $i => $field) {
            $field->name = GeneratorUtils::singularSnakeCase($field->name);
            if ($field->type == 'foreignId') {
                // remove '/' or sub folders
                $constrainModel = GeneratorUtils::setModelName($field->constrain);

                $relatedModelPath = GeneratorUtils::getModelLocation($field->constrain);
                $table = GeneratorUtils::pluralSnakeCase($constrainModel);

                if ($relatedModelPath != '') {
                    $relatedModelPath = "\App\Models\\$relatedModelPath\\$constrainModel";
                } else {
                    $relatedModelPath = "\App\Models\\" . GeneratorUtils::singularPascalCase($constrainModel);
                }

                $allColums = Schema::getColumnListing($table);

                if (sizeof($allColums) > 0) {
                    $fieldsSelect = "'id', '$field->attribute'";
                } else {
                    $fieldsSelect = "'id'";
                }

                if ($i > 1) {
                    $template .= "\t\t";
                }

                $template = str_replace(
                    [
                        '{{modelNamePluralKebabCase}}',
                        '{{constrainsPluralCamelCase}}',
                        '{{constrainsSingularPascalCase}}',
                        '{{fieldsSelect}}',
                        '{{relatedModelPath}}',
                        '{{viewPath}}',
                    ],
                    [
                        GeneratorUtils::pluralKebabCase($model),
                        GeneratorUtils::pluralCamelCase($constrainModel),
                        GeneratorUtils::singularPascalCase($constrainModel),
                        $fieldsSelect,
                        $relatedModelPath,
                        $viewPath != '' ? str_replace('\\', '.', strtolower($viewPath)) . "." : '',
                    ],
                    GeneratorUtils::getTemplate('view-composer')
                );
                $path = app_path('Providers/ViewServiceProvider.php');

                $viewProviderTemplate = substr(file_get_contents($path), 0, -6) . "\n\n\t\t" . $template . "\n\t}\n}";

                file_put_contents($path, $viewProviderTemplate);
            }
        }


    }

    /**
     * remove view composer from viewServiceProvider, if any belongsTo relation.
     *
     * @param $id $id
     *
     * @return void
     */
    public function remove($id)
    {
        $template = "";

        $crud = Crud::find($id);
        $model = GeneratorUtils::setModelName($crud->name, 'default');
        $viewPath = GeneratorUtils::getModelLocation($crud->name);

        foreach ($crud->fields as $i => $feild) {
            if ($feild->type == 'foreignId') {
                // remove '/' or sub folders
                $constrainModel = GeneratorUtils::setModelName($feild->constrain);

                $relatedModelPath = GeneratorUtils::getModelLocation($feild->constrain);
                $table = GeneratorUtils::pluralSnakeCase($constrainModel);

                if ($relatedModelPath != '') {
                    $relatedModelPath = "\App\Models\\$relatedModelPath\\$constrainModel";
                } else {
                    $relatedModelPath = "\App\Models\\" . GeneratorUtils::singularPascalCase($constrainModel);
                }

                $allColums = Schema::getColumnListing($table);

                if (sizeof($allColums) > 0) {
                    $fieldsSelect = "'id', '$allColums[1]'";
                } else {
                    $fieldsSelect = "'id'";
                }

                if ($i > 1) {
                    $template .= "\t\t";
                }

                $template = str_replace(
                    [
                        '{{modelNamePluralKebabCase}}',
                        '{{constrainsPluralCamelCase}}',
                        '{{constrainsSingularPascalCase}}',
                        '{{fieldsSelect}}',
                        '{{relatedModelPath}}',
                        '{{viewPath}}',
                    ],
                    [
                        GeneratorUtils::pluralKebabCase($model),
                        GeneratorUtils::pluralCamelCase($constrainModel),
                        GeneratorUtils::singularPascalCase($constrainModel),
                        $fieldsSelect,
                        $relatedModelPath,
                        $viewPath != '' ? str_replace('\\', '.', strtolower($viewPath)) . "." : '',
                    ],
                    GeneratorUtils::getTemplate('view-composer')
                );
                File::replaceInFile($template, '', app_path('Providers/ViewServiceProvider.php'));
            }
        }
    }
}
