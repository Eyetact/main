<?php

namespace App\Generators;

use App\Enums\ActionForeign;
use App\Models\Module;
use Artisan;

class MigrationGenerator
{
    /**
     * Generate a migration file.
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    public function generate(array $request, $id)
    {
        $model = GeneratorUtils::setModelName($request['code']);
        $tableNamePluralLowercase = GeneratorUtils::pluralSnakeCase($model);

        $setFields = '';
        $totalFields = count($request['fields']);

        if (!empty($request['fields'][0])) {

            foreach ($request['fields'] as $i => $field) {

                $setFields .= "\$table->" . $request['column_types'][$i] . "('" . str()->snake($field);

                if ($request['column_types'][$i] == 'enum') {
                    $options = explode('|', $request['select_options'][$i]);
                    $totalOptions = count($options);

                    $enum = "[";

                    foreach ($options as $key => $value) {
                        if ($key + 1 != $totalOptions) {
                            $enum .= "'$value', ";
                        } else {
                            $enum .= "'$value']";
                        }
                    }

                    $setFields .= "', " . $enum;
                }

                if (isset($request['max_lengths'][$i]) && $request['max_lengths'][$i] >= 0) {
                    if ($request['column_types'][$i] == 'enum') {

                        $setFields .= ")";
                    } else {

                        switch ($request['input_types'][$i]) {
                            case 'range':
                                $setFields .= "')";
                                break;
                            default:
                                $setFields .= "', " . $request['max_lengths'][$i] . ")";
                                break;
                        }
                    }
                } else {
                    if ($request['column_types'][$i] == 'enum') {

                        $setFields .= ")";
                    } else {

                        $setFields .= "')";
                    }
                }

                if ($request['requireds'][$i] != 'yes') {

                    $setFields .= "->nullable()";
                }

                if ($request['default_values'][$i]) {

                    $defaultValue = "'" . $request['default_values'][$i] . "'";

                    if ($request['input_types'][$i] == 'month') {
                        $defaultValue = "\Carbon\Carbon::createFromFormat('Y-m', '" . $request['default_values'][$i] . "')";
                    }

                    $setFields .= "->default($defaultValue)";
                }

                if ($request['input_types'][$i] === 'email') {

                    $setFields .= "->unique()";
                }

                $constrainName = '';
                if ($request['column_types'][$i] == 'foreignId') {
                    $constrainName = GeneratorUtils::setModelName($request['constrains'][$i]);
                }

                if ($i + 1 != $totalFields) {
                    if ($request['column_types'][$i] == 'foreignId') {
                        if ($request['on_delete_foreign'][$i] == ActionForeign::NULL->value) {
                            $setFields .= "->nullable()";
                        }

                        $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

                        if ($request['on_update_foreign'][$i] == ActionForeign::CASCADE->value) {
                            $setFields .= "->cascadeOnUpdate()";
                        } elseif ($request['on_update_foreign'][$i] == ActionForeign::RESTRICT->value) {
                            $setFields .= "->restrictOnUpdate()";
                        }

                        if ($request['on_delete_foreign'][$i] == ActionForeign::CASCADE->value) {
                            $setFields .= "->cascadeOnDelete();\n\t\t\t";
                        } elseif ($request['on_delete_foreign'][$i] == ActionForeign::RESTRICT->value) {
                            $setFields .= "->restrictOnDelete();\n\t\t\t";
                        } elseif ($request['on_delete_foreign'][$i] == ActionForeign::NULL->value) {
                            $setFields .= "->nullOnDelete();\n\t\t\t";
                        } else {
                            $setFields .= ";\n\t\t\t";
                        }
                    } else {
                        $setFields .= ";\n\t\t\t";
                    }
                } else {
                    if ($request['column_types'][$i] == 'foreignId') {
                        $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

                        if ($request['on_update_foreign'][$i] == ActionForeign::CASCADE->value) {
                            $setFields .= "->cascadeOnUpdate()";
                        } elseif ($request['on_update_foreign'][$i] == ActionForeign::RESTRICT->value) {
                            $setFields .= "->restrictOnUpdate()";
                        }

                        if ($request['on_delete_foreign'][$i] == ActionForeign::CASCADE->value) {
                            $setFields .= "->cascadeOnDelete();";
                        } elseif ($request['on_delete_foreign'][$i] == ActionForeign::RESTRICT->value) {
                            $setFields .= "->restrictOnDelete();";
                        } elseif ($request['on_delete_foreign'][$i] == ActionForeign::NULL->value) {
                            $setFields .= "->nullOnDelete();";
                        } else {
                            $setFields .= ";";
                        }
                    } else {
                        $setFields .= ";";
                    }
                }
            }
        }

        $template = str_replace(
            [
                '{{tableNamePluralLowecase}}',
                '{{fields}}',
            ],
            [
                $tableNamePluralLowercase,
                $setFields,
            ],
            GeneratorUtils::getTemplate('migration')
        );

        $migrationName = date('Y') . '_' . date('m') . '_' . date('d') . '_' . date('h') . date('i') . date('s') . '_create_' . $tableNamePluralLowercase . '_table.php';
        $module = Module::find($id);
        $module->migration = $migrationName;
        $module->save();
        file_put_contents(database_path("/migrations/$migrationName"), $template);
    }

    public function reGenerate($id)
    {
        $module = Module::find($id);

        $model = GeneratorUtils::setModelName($module->code);
        $tableNamePluralLowercase = GeneratorUtils::pluralSnakeCase($model);

        $setFields = '';
        $totalFields = count($module->fields);

        foreach ($module->fields()->orderBy('created_at', 'desc')->take(1)->get() as $i => $field) {

            if ($field->type == 'date' && $field->input == 'month') {
                $setFields .= "\$table->text('" . str()->snake($field->name);
            } else {
                $setFields .= "\$table->" . $field->type . "('" . str()->snake($field->name);
            }

            if ($field->type == 'enum') {
                $options = explode('|', $field->select_option);
                $totalOptions = count($options);

                $enum = "[";

                foreach ($options as $key => $value) {
                    if ($key + 1 != $totalOptions) {
                        $enum .= "'$value', ";
                    } else {
                        $enum .= "'$value']";
                    }
                }

                $setFields .= "', " . $enum;
            }

            if (isset($field->max_length) && $field->max_length >= 0) {
                if ($field->type == 'enum') {

                    $setFields .= ")";
                } else {

                    switch ($field->input) {
                        case 'range':
                            $setFields .= "')";
                            break;
                        default:
                            $setFields .= "', " . $field->max_length . ")";
                            break;
                    }
                }
            } else {
                if ($field->type == 'enum') {

                    $setFields .= ")";
                } else {

                    $setFields .= "')";
                }
            }

            if ($field->required != 'on') {

                $setFields .= "->nullable()";
            }

            if ($field->default_value) {

                $defaultValue = "'" . $field->default_value . "'";

                if ($field->type == 'month') {
                    $defaultValue = "\Carbon\Carbon::createFromFormat('Y-m', '" . $field->default_value . "')";
                }

                $setFields .= "->default($defaultValue)";
            }

            if ($field->type === 'email') {

                $setFields .= "->unique()";
            }

            $constrainName = '';
            if ($field->type == 'foreignId') {
                $constrainName = GeneratorUtils::setModelName($field->constrain);
            }

            if ($i + 1 != $totalFields) {
                if ($field->type == 'foreignId') {
                    if ($field->on_delete_foreign == ActionForeign::NULL->value) {
                        $setFields .= "->nullable()";
                    }

                    $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

                    if ($field->on_update_foreign == ActionForeign::CASCADE->value) {
                        $setFields .= "->cascadeOnUpdate()";
                    } elseif ($field->on_update_foreign == ActionForeign::RESTRICT->value) {
                        $setFields .= "->restrictOnUpdate()";
                    }

                    if ($field->on_delete_foreign == ActionForeign::CASCADE->value) {
                        $setFields .= "->cascadeOnDelete();\n\t\t\t";
                    } elseif ($field->on_delete_foreign == ActionForeign::RESTRICT->value) {
                        $setFields .= "->restrictOnDelete();\n\t\t\t";
                    } elseif ($field->on_delete_foreign == ActionForeign::NULL->value) {
                        $setFields .= "->nullOnDelete();\n\t\t\t";
                    } else {
                        $setFields .= ";\n\t\t\t";
                    }
                } else {
                    $setFields .= ";\n\t\t\t";
                }
            } else {
                if ($field->type == 'foreignId') {
                    $setFields .= "->constrained('" . GeneratorUtils::pluralSnakeCase($constrainName) . "')";

                    if ($field->on_update_foreign == ActionForeign::CASCADE->value) {
                        $setFields .= "->cascadeOnUpdate()";
                    } elseif ($field->on_update_foreign == ActionForeign::RESTRICT->value) {
                        $setFields .= "->restrictOnUpdate()";
                    }

                    if ($field->on_delete_foreign == ActionForeign::CASCADE->value) {
                        $setFields .= "->cascadeOnDelete();";
                    } elseif ($field->on_delete_foreign == ActionForeign::RESTRICT->value) {
                        $setFields .= "->restrictOnDelete();";
                    } elseif ($field->on_delete_foreign == ActionForeign::NULL->value) {
                        $setFields .= "->nullOnDelete();";
                    } else {
                        $setFields .= ";";
                    }
                } else {
                    $setFields .= ";";
                }
            }
        }

        $template = str_replace(
            [
                '{{tableNamePluralLowecase}}',
                '{{fields}}',
            ],
            [
                $tableNamePluralLowercase,
                $setFields,
            ],
            GeneratorUtils::getTemplate('migration-edit')
        );

        $migrationName = date('Y') . '_' . date('m') . '_' . date('d') . '_' . date('h') . date('i') . date('s') . '_edit_' . $tableNamePluralLowercase . '_table.php';
        // $module = Module::find($id);
        // $migrationName = $module->migration ;

        file_put_contents(database_path("/migrations/$migrationName"), $template);

        Artisan::call("migrate");

    }
}
