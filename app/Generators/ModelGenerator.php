<?php

namespace App\Generators;

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
        // dd($request);
        $path = GeneratorUtils::getModelLocation($request['name']);
        $model = GeneratorUtils::setModelName($request['name']); 

        $fields = "[";
        $casts = "[";
        $relations = "";
        $methods = "";
        $attr = $request['attr'];
        $totalFields = count($request['attr']);
        $dateTimeFormat = config('generator.format.datetime') ? config('generator.format.datetime') : 'd/m/Y H:i';
        $protectedHidden = "";

       

        switch ($path) {
            case '':
                $namespace = "namespace App\\Models;";
                break;
            default:
                $namespace = "namespace App\\Models\\$path;";
                break;
        }

        foreach ($request['attr'] as $i => $field) {
            switch ($i + 1 != $totalFields) {
                case true:
                    $fields .= "'" . str()->snake($field['input_name']) . "', ";
                    break;
                default:
                    $fields .= "'" . str()->snake($field['input_name']) . "']";
                    break;
            }
            // dd($field['field_type']);
            if ($field['field_type'] == 'password') {
                $protectedHidden .= "'" . str()->snake($field['input_name']) . "', ";

                if ($i > 0) {
                    $methods .= "\t";
                }
                else{
                    $protectedHidden .= <<<PHP
                    /**
                         * The attributes that should be hidden for serialization.
                         *
                         * @var string[]
                        */
                        protected \$hidden = [
                    PHP;
                }

                $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field['input_name']);

                $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\t\$this->attributes['".$field."'] = bcrypt(\$value);\n\t}";
            }

            if ($field['field_type'] == 'file') {

                if ($i > 0) {
                    $methods .= "\t";
                }

                $fieldNameSingularPascalCase = GeneratorUtils::singularPascalCase($field['input_name']);


                $methods .= "\n\tpublic function set" . $fieldNameSingularPascalCase . "Attribute(\$value)\n\t{\n\t\tif (\$value){\n\t\t\t\$file = \$value;\n\t\t\t\$extension = \$file->getClientOriginalExtension(); // getting image extension\n\t\t\t\$filename =time().mt_rand(1000,9999).'.'.\$extension;\n\t\t\t\$file->move(public_path('files/'), \$filename);\n\t\t\t\$this->attributes['".$field['input_name']."'] =  'files/'.\$filename;\n\t\t}\n\t}";
            }



            switch ($field['field_type']) {
                case 'month':
                    $castFormat = config('generator.format.month') ? config('generator.format.month') : 'm/Y';
                    $casts .= "'" . str()->snake($field['input_name']) . "' => 'date:$castFormat', ";
                    break;
                case 'week':
                    $casts .= "'" . str()->snake($field['input_name']) . "' => 'date:Y-\WW', ";
                    break;
            }

       
        }

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
                $model,
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
                file_put_contents(app_path("/Models/$model.php"), $template);
                break;
            default:
                $fullPath = app_path("/Models/$path");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/$model.php", $template);
                break;
        }
    }
}
