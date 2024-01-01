<?php

namespace App\Generators;
use App\Enums\ActionForeign;
use App\Models\Crud;


class MigrationGenerator
{
    /**
     * Generate a migration file.
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['name']);
        $tableNamePluralLowercase = GeneratorUtils::pluralSnakeCase($model);

        $setFields = '';
        $totalFields = count($request['attr']);

        foreach ($request['attr'] as $i => $field) {
            
            $setFields .= "\$table->" . $field['field_type'] . "('" . str()->snake($field['input_name']);

            
            // if ($request['column_types'][$i] == 'enum') {
            //     $options = explode('|', $request['select_options'][$i]);
            //     $totalOptions = count($options);

            //     $enum = "[";

            //     foreach ($options as $key => $value) {
            //         if ($key + 1 != $totalOptions) {
            //             $enum .= "'$value', ";
            //         } else {
            //             $enum .= "'$value']";
            //         }
            //     }

                
            //     $setFields .= "', " . $enum;
            // }

            // if (isset($request['max_lengths'][$i]) && $request['max_lengths'][$i] >= 0) {
            //     if ($request['column_types'][$i] == 'enum') {
                   
            //         $setFields .=  ")";
            //     } else {
                   
            //         switch ($request['input_types'][$i]) {
            //             case 'range':
            //                 $setFields .= "')";
            //                 break;
            //             default:
            //                 $setFields .=  "', " . $request['max_lengths'][$i] . ")";
            //                 break;
            //         }
            //     }
            // } else {
            //     if ($request['column_types'][$i] == 'enum') {
                   
            //         $setFields .=  ")";
            //     } else {
                    
            //         $setFields .= "')";
            //     }
            // }

            if ($field['requireds'] != 'yes') {
               
                $setFields .= "->nullable()";
            }

            // if ($request['default_values'][$i]) {
           
            //     $defaultValue = "'". $request['default_values'][$i] ."'";

            //     if($request['input_types'][$i] == 'month'){
            //         $defaultValue = "\Carbon\Carbon::createFromFormat('Y-m', '". $request['default_values'][$i] ."')";
            //     }

            //     $setFields .= "->default($defaultValue)";
            // }

            // if ($request['input_types'][$i] === 'email') {
               
            //     $setFields .= "->unique()";
            // }

            // $constrainName = '';
            // if ($request['column_types'][$i] == 'foreignId') {
            //     $constrainName = GeneratorUtils::setModelName($request['constrains'][$i]);
            // }

            // if ($i + 1 != $totalFields) {
            //     if ($request['column_types'][$i] == 'foreignId') {
            //         if($request['on_delete_foreign'][$i] == ActionForeign::NULL->value){
            //             $setFields .= "->nullable()";
            //         }

            //         $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

            //         if($request['on_update_foreign'][$i] == ActionForeign::CASCADE->value){
            //             $setFields .= "->cascadeOnUpdate()";
            //         }elseif($request['on_update_foreign'][$i] == ActionForeign::RESTRICT->value){
            //             $setFields .= "->restrictOnUpdate()";
            //         }

            //         if($request['on_delete_foreign'][$i] == ActionForeign::CASCADE->value){
            //             $setFields .= "->cascadeOnDelete();\n\t\t\t";
            //         }elseif($request['on_delete_foreign'][$i] == ActionForeign::RESTRICT->value){
            //             $setFields .= "->restrictOnDelete();\n\t\t\t";
            //         }elseif($request['on_delete_foreign'][$i] == ActionForeign::NULL->value){
            //             $setFields .= "->nullOnDelete();\n\t\t\t";
            //         }else{
            //             $setFields .= ";\n\t\t\t";
            //         }
            //     } else {
            //         $setFields .= ";\n\t\t\t";
            //     }
            // } else {
            //     if ($request['column_types'][$i] == 'foreignId') {
            //         $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

            //         if($request['on_update_foreign'][$i] == ActionForeign::CASCADE->value){
            //             $setFields .= "->cascadeOnUpdate()";
            //         }elseif($request['on_update_foreign'][$i] == ActionForeign::RESTRICT->value){
            //             $setFields .= "->restrictOnUpdate()";
            //         }

            //         if($request['on_delete_foreign'][$i] == ActionForeign::CASCADE->value){
            //             $setFields .= "->cascadeOnDelete();";
            //         }elseif($request['on_delete_foreign'][$i] == ActionForeign::RESTRICT->value){
            //             $setFields .= "->restrictOnDelete();";
            //         }elseif($request['on_delete_foreign'][$i] == ActionForeign::NULL->value){
            //             $setFields .= "->nullOnDelete();";
            //         }else{
            //             $setFields .= ";";
            //         }
            //     } else {
            //         $setFields .= ";";
            //     }
            // }
        }

        $template = str_replace(
            [
                '{{tableNamePluralLowecase}}',
                '{{fields}}'
            ],
            [
                $tableNamePluralLowercase,
                $setFields
            ],
            GeneratorUtils::getTemplate('migration')
        );

        $migrationName = date('Y') . '_' . date('m') . '_' . date('d')  . '_' . date('h') .  date('i') . date('s') . '_create_' . $tableNamePluralLowercase . '_table.php';
        file_put_contents(database_path("/migrations/$migrationName"), $template);
    }
}
