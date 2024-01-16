<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;
use App\Models\Crud;
use App\Models\Module;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class IndexViewGenerator
{
    /**
     * Generate an index view.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['name'], 'default');
        $path = GeneratorUtils::getModelLocation($request['name']);

        $code = GeneratorUtils::setModelName($request['code'], 'default');
        $modelName = GeneratorUtils::pluralKebabCase($code);


        $modelNamePluralUcWords = GeneratorUtils::cleanPluralUcWords($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);
        $modelNamePluralLowerCase = GeneratorUtils::cleanPluralLowerCase($model);
        $modelNameSingularLowercase = GeneratorUtils::cleanSingularLowerCase($model);

        $thColums = '';
        $tdColumns = '';
        $totalFields = count($request['fields']);

        if (!empty($request['fields'][0])) {
        foreach ($request['fields'] as $i => $field) {
            if ($request['input_types'][$i] != 'password') {
                /**
                 * will generate something like:
                 * <th>{{ __('Price') }}</th>
                 */
                if ($request['column_types'][$i] != 'foreignId') {
                    $thColums .= "<th>{{ __('" .  GeneratorUtils::cleanUcWords($field) . "') }}</th>";
                }

                if ($request['input_types'][$i] == 'file') {
                    /**
                     * will generate something like:
                     * {
                     *    data: 'photo',
                     *    name: 'photo',
                     *    orderable: false,
                     *    searchable: false,
                     *    render: function(data, type, full, meta) {
                     *        return `<div class="avatar">
                     *            <img src="${data}" alt="Photo">
                     *        </div>`;
                     *    }
                     * },
                     */

                    $tdColumns .=  "{
                    data: '" . str()->snake($field) . "',
                    name: '" . str()->snake($field) . "',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class=\"avatar\">
                            <img src=\"" . '$' . "{data}\" alt=\"" . GeneratorUtils::cleanSingularUcWords($field) . "\">
                        </div>`;
                        }
                    },";
                } elseif ($request['column_types'][$i] == 'foreignId') {
                    // remove '/' or sub folders
                    $constrainModel = GeneratorUtils::setModelName($request['constrains'][$i], 'default');

                    $thColums .= "<th>{{ __('" .  GeneratorUtils::cleanSingularUcWords($constrainModel) . "') }}</th>";

                    /**
                     * will generate something like:
                     * {
                     *    data: 'user',
                     *    name: 'user.name'
                     * }
                     */
                    $tdColumns .=  "{
                    data: '" . GeneratorUtils::singularSnakeCase($constrainModel) . "',
                    name: '" . GeneratorUtils::singularSnakeCase($constrainModel) . "." . GeneratorUtils::getColumnAfterId($constrainModel) . "'
                },";
                } else {
                    /**
                     * will generate something like:
                     * {
                     *    data: 'price',
                     *    name: 'price'
                     * }
                     */
                    $tdColumns .=  "{
                    data: '" . str()->snake($field) . "',
                    name: '" . str()->snake($field) . "',
                },";
                }

                if ($i + 1 != $totalFields) {
                    // add new line and tab
                    $thColums .= "\n\t\t\t\t\t\t\t\t\t\t\t";
                    $tdColumns .= "\n\t\t\t\t";
                }
            }
        }
    }

        $template = str_replace(
            [
                '{{modelNamePluralUcWords}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
                '{{thColumns}}',
                '{{tdColumns}}'
            ],
            [
                $modelNamePluralUcWords,
                $modelNamePluralKebabCase,
                $modelNameSingularLowercase,
                $modelNamePluralLowerCase,
                $thColums,
                $tdColumns
            ],
            GeneratorUtils::getTemplate('views/index')
        );

        switch ($path) {
            case '':
                GeneratorUtils::checkFolder(resource_path("/views/admin/$modelName"));
                file_put_contents(resource_path("/views/admin/$modelName/index.blade.php"), $template);
                break;
            default:
                $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelName");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/index.blade.php", $template);
                break;
        }
    }

    public function reGenerate($id)
    {
        $module = Module::find($id);
        $model = GeneratorUtils::setModelName($module->name, 'default');
        $path = GeneratorUtils::getModelLocation($module->name);

        $modelNamePluralUcWords = GeneratorUtils::cleanPluralUcWords($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);
        $modelNamePluralLowerCase = GeneratorUtils::cleanPluralLowerCase($model);
        $modelNameSingularLowercase = GeneratorUtils::cleanSingularLowerCase($model);

        $thColums = '';
        $tdColumns = '';
        $totalFields = count($module->fields);

        foreach ($module->fields as $i => $field) {
            if ($field->input != 'password') {
                /**
                 * will generate something like:
                 * <th>{{ __('Price') }}</th>
                 */
                if ($field->type != 'foreignId') {
                    $thColums .= "<th>{{ __('" .  GeneratorUtils::cleanUcWords($field->name) . "') }}</th>";
                }

                if ($field->input == 'file') {
                    /**
                     * will generate something like:
                     * {
                     *    data: 'photo',
                     *    name: 'photo',
                     *    orderable: false,
                     *    searchable: false,
                     *    render: function(data, type, full, meta) {
                     *        return `<div class="avatar">
                     *            <img src="${data}" alt="Photo">
                     *        </div>`;
                     *    }
                     * },
                     */

                    $tdColumns .=  "{
                    data: '" . str()->snake($field->name) . "',
                    name: '" . str()->snake($field->name) . "',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class=\"avatar\">
                            <img src=\"" . '$' . "{data}\" alt=\"" . GeneratorUtils::cleanSingularUcWords($field->name) . "\">
                        </div>`;
                        }
                    },";
                } elseif ($field->type == 'foreignId') {
                    // remove '/' or sub folders
                    $constrainModel = GeneratorUtils::setModelName($field->constrain , 'default');

                    $thColums .= "<th>{{ __('" .  GeneratorUtils::cleanSingularUcWords($constrainModel) . "') }}</th>";

                    /**
                     * will generate something like:
                     * {
                     *    data: 'user',
                     *    name: 'user.name'
                     * }
                     */
                    $tdColumns .=  "{
                    data: '" . GeneratorUtils::singularSnakeCase($constrainModel) . "',
                    name: '" . GeneratorUtils::singularSnakeCase($constrainModel) . "." . GeneratorUtils::getColumnAfterId($constrainModel) . "'
                },";
                } else {
                    /**
                     * will generate something like:
                     * {
                     *    data: 'price',
                     *    name: 'price'
                     * }
                     */
                    $tdColumns .=  "{
                    data: '" . str()->snake($field->name) . "',
                    name: '" . str()->snake($field->name) . "',
                },";
                }

                if ($i + 1 != $totalFields) {
                    // add new line and tab
                    $thColums .= "\n\t\t\t\t\t\t\t\t\t\t\t";
                    $tdColumns .= "\n\t\t\t\t";
                }
            }
        }

        $template = str_replace(
            [
                '{{modelNamePluralUcWords}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
                '{{thColumns}}',
                '{{tdColumns}}'
            ],
            [
                $modelNamePluralUcWords,
                $modelNamePluralKebabCase,
                $modelNameSingularLowercase,
                $modelNamePluralLowerCase,
                $thColums,
                $tdColumns
            ],
            GeneratorUtils::getTemplate('views/index')
        );

        switch ($path) {
            case '':
                GeneratorUtils::checkFolder(resource_path("/views/admin/$modelNamePluralKebabCase"));
                file_put_contents(resource_path("/views/admin/$modelNamePluralKebabCase/index.blade.php"), $template);
                break;
            default:
                $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelNamePluralKebabCase");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/index.blade.php", $template);
                break;
        }
    }

    /**
     * Method remove
     *
     * @param $id $id
     *
     * @return void
     */
    public function remove($id){
        $crud = Crud::find($id);
        $model = GeneratorUtils::setModelName($crud->name, 'default');
        $path = GeneratorUtils::getModelLocation($crud->name);

        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);

        switch ($path) {
            case '':
                $fullPath = resource_path("/views/admin/$modelNamePluralKebabCase");
                $this->removeDir($fullPath);
                break;
            default:
                $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelNamePluralKebabCase");
                $this->removeDir($fullPath);
                break;
        }
    }

    /**
     * Method removeDir
     *
     * @param string $dir
     *
     * @return void
     */
    protected function removeDir(string $dir): void {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                     RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($dir);
    }
}
