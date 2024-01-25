<?php

namespace App\Generators;
use App\Models\Module;

class ModelGenerator
{
    /**
     * Generate a model file.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $path = GeneratorUtils::getModelLocation($request['name']);
        $model = GeneratorUtils::setModelName($request['name']);
        $modelName = GeneratorUtils::setModelName($request['code']);

        $fields = "[";
        $casts = "[";
        $relations = "";
        $methods = "";
        $totalFields = !empty($request['fields']) ?count($request['fields']) : 0;
        $dateTimeFormat = config('generator.format.datetime') ? config('generator.format.datetime') : 'd/m/Y H:i';
        $protectedHidden = "";
        if (!empty($request['fields'][0])) {
            if (in_array('password', $request['input_types'])) {
                $protectedHidden .= <<<PHP
            /**
                 * The attributes that should be hidden for serialization.
                 *
                 * @var string[]
                */
                protected \$hidden = [
            PHP;
            }
        }

        switch ($path) {
            case '':
                $namespace = "namespace App\\Models;";
                break;
            default:
                $namespace = "namespace App\\Models\\$path;";
                break;
        }

        if (!empty($request['fields'][0])) {


            foreach ($request['fields'] as $i => $field) {
                switch ($i + 1 != $totalFields) {
                    case true:
                        $fields .= "'" . str()->snake($field) . "', ";
                        break;
                    default:
                        $fields .= "'" . str()->snake($field) . "'";
                        break;
                }

                if ($request['input_types'][$i] == 'password') {
                    $protectedHidden .= "'" . str()->snake($field) . "', ";

                    if ($i > 0) {
                        $methods .= "\t";
                    }

                    $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field);

                    $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\t\$this->attributes['" . $field . "'] = bcrypt(\$value);\n\t}";
                }

                if ($request['input_types'][$i] == 'file') {

                    if ($i > 0) {
                        $methods .= "\t";
                    }

                    $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field);


                    $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\tif (\$value){\n\t\t\t\$file = \$value;\n\t\t\t\$extension = \$file->getClientOriginalExtension(); // getting image extension\n\t\t\t\$filename =time().mt_rand(1000,9999).'.'.\$extension;\n\t\t\t\$file->move(public_path('files/'), \$filename);\n\t\t\t\$this->attributes['" . $field . "'] =  'files/'.\$filename;\n\t\t}\n\t}";
                }

                switch ($request['column_types'][$i]) {
                    case 'date':
                        if ($request['input_types'][$i] != 'month') {
                            $dateFormat = config('generator.format.date') ? config('generator.format.date') : 'd/m/Y';
                            $casts .= "'" . str()->snake($field) . "' => 'date:$dateFormat', ";
                        }
                        break;
                    case 'time':
                        $timeFormat = config('generator.format.time') ? config('generator.format.time') : 'H:i';
                        $casts .= "'" . str()->snake($field) . "' => 'datetime:$timeFormat', ";
                        break;
                    case 'year':
                        $casts .= "'" . str()->snake($field) . "' => 'integer', ";
                        break;
                    case 'dateTime':
                        $casts .= "'" . str()->snake($field) . "' => 'datetime:$dateTimeFormat', ";
                        break;
                    case 'float':
                        $casts .= "'" . str()->snake($field) . "' => 'float', ";
                        break;
                    case 'boolean':
                        $casts .= "'" . str()->snake($field) . "' => 'boolean', ";
                        break;
                    case 'double':
                        $casts .= "'" . str()->snake($field) . "' => 'double', ";
                        break;
                    case 'foreignId':
                        $constrainPath = GeneratorUtils::getModelLocation($request['constrains'][$i]);
                        $constrainName = GeneratorUtils::setModelName($request['constrains'][$i]);

                        $foreign_id = isset($request['foreign_ids'][$i]) ? ", '" . $request['foreign_ids'][$i] . "'" : '';

                        if ($i > 0) {
                            $relations .= "\t";
                        }

                        if ($constrainPath != '') {
                            $constrainPath = "\\App\\Models\\$constrainPath\\$constrainName";
                        } else {
                            $constrainPath = "\\App\\Models\\$constrainName";
                        }

                        $relations .= "\n\tpublic function " . str()->snake($constrainName) . "()\n\t{\n\t\treturn \$this->belongsTo(" . $constrainPath . "::class" . $foreign_id . ");\n\t}";

                        break;
                }

                switch ($request['input_types'][$i]) {
                    case 'month':
                        $castFormat = config('generator.format.month') ? config('generator.format.month') : 'm/Y';
                        $casts .= "'" . str()->snake($field) . "' => 'date:$castFormat', ";
                        break;
                    case 'week':
                        $casts .= "'" . str()->snake($field) . "' => 'date:Y-\WW', ";
                        break;
                }

                if (str_contains($request['column_types'][$i], 'integer')) {
                    $casts .= "'" . str()->snake($field) . "' => 'integer', ";
                }

                if (
                    str_contains($request['column_types'][$i], 'string') ||
                    str_contains($request['column_types'][$i], 'text') ||
                    str_contains($request['column_types'][$i], 'char')
                ) {
                    if ($request['input_types'][$i] != 'week') {
                        $casts .= "'" . str()->snake($field) . "' => 'string', ";
                    }
                }
            }
        }

        $fields .=  "]";


        if ($protectedHidden != "") {
            $protectedHidden = substr($protectedHidden, 0, -2);
            $protectedHidden .= "];";
        }

        $casts .= <<<PHP
        'created_at' => 'datetime:$dateTimeFormat', 'updated_at' => 'datetime:$dateTimeFormat']
        PHP;

        $template = str_replace(
            [
                '{{modelName}}',
                '{{fields}}',
                '{{casts}}',
                '{{relations}}',
                '{{namespace}}',
                '{{protectedHidden}}',
                '{{methods}}'
            ],
            [
                $modelName,
                $fields,
                $casts,
                $relations,
                $namespace,
                $protectedHidden,
                $methods
            ],
            GeneratorUtils::getTemplate('model')
        );

        switch ($path) {
            case '':
                file_put_contents(app_path("/Models/$modelName.php"), $template);
                break;
            default:
                $fullPath = app_path("/Models/$path");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/$modelName.php", $template);
                break;
        }
    }


    public function reGenerate($id)
    {
        $module = Module::find($id);
        $path = GeneratorUtils::getModelLocation($module->name);
        $model = GeneratorUtils::setModelName($module->name);
        $modelName = GeneratorUtils::setModelName($module->code);

        $fields = "[";
        $casts = "[";
        $relations = "";
        $methods = "";
        $totalFields = count($module->fields);
        $dateTimeFormat = config('generator.format.datetime') ? config('generator.format.datetime') : 'd/m/Y H:i';
        $protectedHidden = "";


            if (count($module->fields()->where('input','password')->get()) > 0) {
                $protectedHidden .= <<<PHP
            /**
                 * The attributes that should be hidden for serialization.
                 *
                 * @var string[]
                */
                protected \$hidden = [
            PHP;
            }


        switch ($path) {
            case '':
                $namespace = "namespace App\\Models;";
                break;
            default:
                $namespace = "namespace App\\Models\\$path;";
                break;
        }



            foreach ($module->fields as $i => $field) {
                switch ($i + 1 != $totalFields) {
                    case true:
                        $fields .= "'" . str()->snake($field->name) . "', ";
                        break;
                    default:
                        $fields .= "'" . str()->snake($field->name) . "'";
                        break;
                }

                if ($field->input == 'password') {
                    $protectedHidden .= "'" . str()->snake($field->name) . "', ";

                    if ($i > 0) {
                        $methods .= "\t";
                    }

                    $fieldNameSingularPascalCase = GeneratorUtils::pluralPascalCase($field->name);

                    $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\t\$this->attributes['" . $field->name . "'] = bcrypt(\$value);\n\t}";
                }

                if ($field->input == 'multi') {

                    if ($i > 0) {
                        $methods .= "\t";
                    }

                    $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field->name);

                    $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\tif(\$value){\$this->attributes['" . $field->name . "'] = json_encode(\$value,true);}else{ \$this->attributes['" . $field->name . "'] = null; }\n\t}";
                }

                if ($field->input == 'file'  || $field->input == 'image') {

                    if ($i > 0) {
                        $methods .= "\t";
                    }

                    $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field->name);


                    $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\tif (\$value){\n\t\t\t\$file = \$value;\n\t\t\t\$extension = \$file->getClientOriginalExtension(); // getting image extension\n\t\t\t\$filename =time().mt_rand(1000,9999).'.'.\$extension;\n\t\t\t\$file->move(public_path('files/'), \$filename);\n\t\t\t\$this->attributes['" . $field->name . "'] =  'files/'.\$filename;\n\t\t}\n\t}";
                }

                switch ($field->type) {
                    case 'date':
                        if ($field->input != 'month') {
                            $dateFormat = config('generator.format.date') ? config('generator.format.date') : 'd/m/Y';
                            $casts .= "'" . str()->snake($field->name) . "' => 'date:$dateFormat', ";
                        }
                        break;
                    case 'time':
                        $timeFormat = config('generator.format.time') ? config('generator.format.time') : 'H:i';
                        $casts .= "'" . str()->snake($field->name) . "' => 'datetime:$timeFormat', ";
                        break;
                    case 'year':
                        $casts .= "'" . str()->snake($field->name) . "' => 'integer', ";
                        break;
                    case 'dateTime':
                        $casts .= "'" . str()->snake($field->name) . "' => 'datetime:$dateTimeFormat', ";
                        break;
                    case 'float':
                        $casts .= "'" . str()->snake($field->name) . "' => 'float', ";
                        break;
                    case 'boolean':
                        $casts .= "'" . str()->snake($field->name) . "' => 'boolean', ";
                        break;
                    case 'double':
                        $casts .= "'" . str()->snake($field->name) . "' => 'double', ";
                        break;
                    case 'foreignId':
                        $constrainPath = GeneratorUtils::getModelLocation($field->constrain);
                        $constrainName = GeneratorUtils::setModelName($field->constrain);

                        $foreign_id = isset($field->foreign_ids) ? ", '" . $field->foreign_ids . "'" : '';

                        if ($i > 0) {
                            $relations .= "\t";
                        }

                        if ($constrainPath != '') {
                            $constrainPath = "\\App\\Models\\$constrainPath\\$constrainName";
                        } else {
                            $constrainPath = "\\App\\Models\\$constrainName";
                        }

                        $relations .= "\n\tpublic function " . str()->snake($constrainName) . "()\n\t{\n\t\treturn \$this->belongsTo(" . $constrainPath . "::class" . $foreign_id . ");\n\t}";

                        break;
                }

                switch ($field->input) {
                    case 'month':
                        $castFormat = config('generator.format.month') ? config('generator.format.month') : 'm/Y';
                        $casts .= "'" . str()->snake($field->name) . "' => 'date:$castFormat', ";
                        break;
                    case 'week':
                        $casts .= "'" . str()->snake($field->name) . "' => 'date:Y-\WW', ";
                        break;
                }

                if (str_contains($field->type, 'integer')) {
                    $casts .= "'" . str()->snake($field->name) . "' => 'integer', ";
                }

                if (
                    str_contains($field->type, 'string') ||
                    str_contains($field->type, 'text') ||
                    str_contains($field->type, 'char')
                ) {
                    if ($field->input != 'week') {
                        $casts .= "'" . str()->snake($field->name) . "' => 'string', ";
                    }
                }
            }


        $fields .=  "]";


        if ($protectedHidden != "") {
            $protectedHidden = substr($protectedHidden, 0, -2);
            $protectedHidden .= "];";
        }

        $casts .= <<<PHP
        'created_at' => 'datetime:$dateTimeFormat', 'updated_at' => 'datetime:$dateTimeFormat']
        PHP;

        $template = str_replace(
            [
                '{{modelName}}',
                '{{fields}}',
                '{{casts}}',
                '{{relations}}',
                '{{namespace}}',
                '{{protectedHidden}}',
                '{{methods}}'
            ],
            [
                $modelName,
                $fields,
                $casts,
                $relations,
                $namespace,
                $protectedHidden,
                $methods
            ],
            GeneratorUtils::getTemplate('model')
        );

        switch ($path) {
            case '':
                file_put_contents(app_path("/Models/$modelName.php"), $template);
                break;
            default:
                $fullPath = app_path("/Models/$path");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/$modelName.php", $template);
                break;
        }
    }
}
