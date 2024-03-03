<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;
use App\Models\Crud;
use App\Models\Module;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Facades\File;


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
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);
        $modelNamePluralLowerCase = GeneratorUtils::cleanPluralLowerCase($model);
        $modelNameSingularLowercase = GeneratorUtils::cleanSingularLowerCase($model);

        $thColums = '';
        $tdColumns = '';
        $totalFields = !empty($request['fields']) ?count($request['fields']) : 0;

        if (!empty($request['fields'][0])) {
            foreach ($request['fields'] as $i => $field) {
                if ($request['input_types'][$i] != 'password') {
                    /**
                     * will generate something like:
                     * <th>{{ __('Price') }}</th>
                     */
                    if ($request['column_types'][$i] != 'foreignId') {
                        $thColums .= "<th>{{ __('" . GeneratorUtils::cleanUcWords($field) . "') }}</th>";
                    }

                    if ($request['input_types'][$i] == 'image') {
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

                        $tdColumns .= "{
                    data: \"" . str()->snake($field) . "\",
                    name: \"" . str()->snake($field) . "\",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class=\"avatar\">
                            <img src=\"" . '$' . "{data}\" alt=\"" . GeneratorUtils::cleanSingularUcWords($field) . "\">
                        </div>`;
                        }
                    },";
                    } else if ($request['input_types'][$i] == 'file') {
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

                        $tdColumns .= "{
                    data: \"" . str()->snake($field) . "\",
                    name: \"" . str()->snake($field) . "\",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class=\"avatar\">
                            {data}
                        </div>`;
                        }
                    },";
                    } elseif ($request['column_types'][$i] == 'foreignId') {
                        // remove '/' or sub folders
                        $constrainModel = GeneratorUtils::setModelName($request['constrains'][$i], 'default');

                        $thColums .= "<th>{{ __('" . GeneratorUtils::cleanSingularUcWords($constrainModel) . "') }}</th>";

                        /**
                         * will generate something like:
                         * {
                         *    data: 'user',
                         *    name: 'user.name'
                         * }
                         */
                        $tdColumns .= "{
                    data: \"" . GeneratorUtils::singularSnakeCase($constrainModel) . "\",
                    name: \"" . GeneratorUtils::singularSnakeCase($constrainModel) . "." . GeneratorUtils::getColumnAfterId($constrainModel) . "\"
                },";
                    } else {
                        /**
                         * will generate something like:
                         * {
                         *    data: 'price',
                         *    name: 'price'
                         * }
                         */
                        $tdColumns .= "{
                    data: \"" . str()->snake($field) . "\",
                    name: \"" . str()->snake($field) . "\",
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
                '{{modelNameSingularLowercase}}',
                '{{modelNamePluralLowerCase}}',
                '{{thColumns}}',
                '{{tdColumns}}',
                '{{trHtml}}'
            ],
            [
                $modelNamePluralUcWords,
                $modelNamePluralKebabCase,
                $modelNameSingularLowercase,
                $modelNamePluralLowerCase,
                $thColums,
                $tdColumns,
                ''
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

        $code = GeneratorUtils::setModelName($module->code, 'default');
        $modelName = GeneratorUtils::pluralKebabCase($code);

        $modelNamePluralUcWords = GeneratorUtils::cleanPluralUcWords($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);
        $modelNamePluralLowerCase = GeneratorUtils::cleanPluralLowerCase($model);
        $modelNameSingularLowercase = GeneratorUtils::cleanSingularLowerCase($code);

        $thColums = '';
        $tdColumns = '';
        $trhtml='';
        $totalFields = count($module->fields()->where('is_enable',1)->get());

        foreach ($module->fields()->where('is_enable',1)->get() as $i => $field) {
            $field->name = GeneratorUtils::singularSnakeCase($field->name);
            $field->code = !empty($field->code) ?  GeneratorUtils::singularSnakeCase($field->code) : GeneratorUtils::singularSnakeCase($field->name);

            if ($field->input != 'password') {
                /**
                 * will generate something like:
                 * <th>{{ __('Price') }}</th>
                 */
                if ($field->type != 'foreignId') {
                    $thColums .= "<th>{{ __('" . GeneratorUtils::cleanUcWords($field->name) . "') }}</th>";
                }

                if ($field->type == 'multi') {
                    $trhtml .= "        $(document).on('click', '#add_new_tr_".$field->id."', function() {
                        let table = $('#tbl-field-".$field->id." tbody')
                        var list_".$field->id." = ''
                        let no = table.find('tr').length + 1\n";

                        foreach ($field->multis as $key => $value) {
                            switch ($value->type) {
                            case 'foreignId':
                                $trhtml .= '@foreach( \\App\\Models\\Admin\\'. GeneratorUtils::singularPascalCase($value->constrain).'::all() as $item2 )
                                ';
                                $trhtml .= 'list_'.$field->id.' += \'<option  value="{{ $item2->'.$value->attribute . '}}" >{{ $item2->'.$value->attribute . '}}</option>\'
                                ';
                                $trhtml .= '@endforeach
                                console.log(list_'.$field->id.')
                                ';
                                break;
                             }
                        }

                        $trhtml .= "let tr = `";

                    $trhtml .= '<tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;">';
                    foreach ($field->multis as $key => $value) {
                        switch ($value->type) {

                            case 'text':
                            case 'email':
                            case 'tel':
                            case 'url':
                            case 'search':
                            case 'file':
                            case 'number':
                            case 'date':
                            case 'time':
                                $trhtml .= ' <td>
                                        <div class="input-box">
                                            <input type="' . $value->type . '" name="' . $field->code . '[${no}][' . $value->name . ']"
                                                class="form-control google-input"
                                                placeholder="' . $value->name . '" required>
                                        </div>
                                    </td>
                                    ';
                                break;
                                case 'decimal':
                                    $trhtml .= ' <td>
                                            <div class="input-box">
                                                <input type="number" step="0.000000000000000001" name="' . $field->code . '[${no}][' . $value->name . ']"
                                                    class="form-control google-input"
                                                    placeholder="' . $value->name . '" required>
                                            </div>
                                        </td>
                                        ';
                                    break;
                            case 'image':
                                $trhtml .= ' <td>
                                            <div class="input-box">
                                                <input type="file" name="' . $field->code . '[${no}][' . $value->name . ']"
                                                    class="form-control google-input"
                                                    placeholder="' . $value->name . '" required>
                                            </div>
                                        </td>
                                        ';
                                break;

                            case 'textarea':
                                $trhtml .= ' <td>
                                            <div class="input-box">

                                            <textarea name="' . $field->code . '[${no}][' . $value->name . ']"  class="google-input"  placeholder="' . $value->name . '"></textarea>

                                            </div>
                                        </td>
                                        ';
                                break;

                                case 'texteditor':
                                    $trhtml .= ' <td>
                                                <div class="input-box">

                                                <textarea name="' . $field->code . '[${no}][' . $value->name . ']"  class="content"  placeholder="' . $value->name . '"></textarea>

                                                </div>
                                            </td>
                                            ';
                                    break;

                            case 'range':
                                $trhtml .= '<td>
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="input-box">
                                                                <input onmousemove="' . $value->name . '1.value=value" type="range" name="' . $field->code . '[' . $value->name . ']" class="range " min="1" max="1000" >

                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">  <output id="' . $value->name . '1"></output></div>
                                                    </div>
                                                </td>
                                                    ';
                                break;
                            case 'radio':
                                $trhtml .= '<td>
                                    <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio" for="' . $value->name . '-1">
                                        <input class="custom-control-input" type="radio" name="' . $field->code . '[${no}][' . $value->name . ']" id="' . $value->name . '-1" value="1">
                                        <span class="custom-control-label">True</span>
                                    </label>

                                    <label class="custom-control custom-radio" for="' . $value->name . '-0">
                                        <input class="custom-control-input" type="radio" name="' . $field->code . '[${no}][' . $value->name . ']" id="' . $value->name . '-0" value="0">
                                        <span class="custom-control-label">False</span>
                                    </label>
                                </div>
                                                </td>
                                                            ';
                                break;
                            case 'select':

                                $arrOption = explode('|', $value->select_options);

                                $totalOptions = count($arrOption);
                                $trhtml .= '<td><div class="input-box">';
                                $trhtml .= ' <select name="' . $field->code . '[${no}][' . $value->name . ']" class="form-select  google-input multi-type" required="">';

                                foreach ($arrOption as $arrOptionIndex => $value) {
                                    $trhtml .= '<option value="'.$value.'" >'.$value.'</option>';

                                }
                                $trhtml .= '</select>';
                                $trhtml .= '</div></td>';
                                break;

                                case 'foreignId':

                                    $trhtml .= '<td><div class="input-box">';
                                    $trhtml .= ' <select name="' . $field->code . '[${no}][\'' . $value->code . '\']" class="form-select  google-input multi-type" required="">';
                                    $trhtml .= '${list_'.$field->id.'}';
                                    $trhtml .= '</select>';
                                    $trhtml .= '</div></td>';
                                    break;

                            default:
                                # code...
                                break;
                        }

                    }
                    $trhtml .= '
                    <td>
                        <div class="input-box">

                            <button type="button"
                                class="btn btn-outline-danger btn-xs btn-delete">
                                x
                            </button>
                        </div>
                    </td>
                    </tr>';
                    $trhtml .= "`

                            table.append(tr)

                            table.find('.content:last').richText();

                        });\n";
                        }


                    $subMulti = "<script>". $trhtml ."</script>";



                    if($module->parent_id > 0){
                        $parentModule = Module::find($module->parent_id);
                        $parentCode = GeneratorUtils::setModelName($parentModule->code, 'default');
                        $parentModelName = GeneratorUtils::pluralKebabCase($parentCode);

                        File::append(resource_path("/views/admin/$parentModelName/include/multi.blade.php"), $subMulti);

                    }



                if ($field->input == 'image') {
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

                    $tdColumns .= "{
                    data: \"" . str()->snake($field->code) . "\",
                    name: \"" . str()->snake($field->name) . "\",
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
                    $constrainModel = GeneratorUtils::setModelName($field->constrain, 'default');

                    $thColums .= "<th>{{ __('" . GeneratorUtils::cleanSingularUcWords($constrainModel) . "') }}</th>";

                    /**
                     * will generate something like:
                     * {
                     *    data: 'user',
                     *    name: 'user.name'
                     * }
                     */
                    $tdColumns .= "{
                    data: \"" . GeneratorUtils::singularSnakeCase($constrainModel) . "\",
                    name: \"" . GeneratorUtils::singularSnakeCase($constrainModel) . "." . $field->attribute . "\"
                },";
                } else {
                    /**
                     * will generate something like:
                     * {
                     *    data: 'price',
                     *    name: 'price'
                     * }
                     */
                    $tdColumns .= "{
                    data: \"" . str()->snake($field->code) . "\",
                    name: \"" . str()->snake($field->name) . "\",
                },";
                }

                if ($i + 1 != $totalFields) {
                    // add new line and tab
                    $thColums .= "\n\t\t\t\t\t\t\t\t\t\t\t";
                    $tdColumns .= "\n\t\t\t\t";
                }
            }
        }

        // dd($trhtml);
        $template = str_replace(
            [
                '{{modelNamePluralUcWords}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSingularLowercase}}',
                '{{modelNamePluralLowerCase}}',
                '{{thColumns}}',
                '{{tdColumns}}',
                '{{trHtml}}'
            ],
            [
                $modelNamePluralUcWords,
                $modelNamePluralKebabCase,
                $modelNameSingularLowercase,
                $modelNamePluralLowerCase,
                $thColums,
                $tdColumns,
                $trhtml
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

    /**
     * Method remove
     *
     * @param $id $id
     *
     * @return void
     */
    public function remove($id)
    {
        $crud = Module::find($id);
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
    protected function removeDir(string $dir): void
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($dir);
    }
}
