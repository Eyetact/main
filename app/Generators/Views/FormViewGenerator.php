<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;
use App\Models\Module;

class FormViewGenerator
{
    /**
     * Generate a form/input for create and edit.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['name']);
        $path = GeneratorUtils::getModelLocation($request['name']);
        $code = GeneratorUtils::setModelName($request['code']);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($code);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);

        $template = "<div class=\"row mb-2\">\n";

        if (!empty($request['fields'][0])) {
            foreach ($request['fields'] as $i => $field) {

                if ($request['input_types'][$i] !== 'no-input') {
                    $fieldSnakeCase = str($field)->snake();

                    $fieldUcWords = GeneratorUtils::cleanUcWords($field);

                    switch ($request['column_types'][$i]) {
                        case 'enum':
                            $options = "";

                            $arrOption = explode('|', $request['select_options'][$i]);

                            $totalOptions = count($arrOption);

                            switch ($request['input_types'][$i]) {
                                case 'select':
                                    // select
                                    foreach ($arrOption as $arrOptionIndex => $value) {
                                        $options .= <<<BLADE
                                    <option value="$value" {{ isset(\$$modelNameSingularCamelCase) && \$$modelNameSingularCamelCase->$fieldSnakeCase == '$value' ? 'selected' : (old('$fieldSnakeCase') == '$value' ? 'selected' : '') }}>$value</option>
                                    BLADE;

                                        if ($arrOptionIndex + 1 != $totalOptions) {
                                            $options .= "\n\t\t";
                                        } else {
                                            $options .= "\t\t\t";
                                        }
                                    }

                                    $template .= str_replace(
                                        [
                                            '{{fieldUcWords}}',
                                            '{{fieldKebabCase}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldSpaceLowercase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                        ],
                                        [
                                            $fieldUcWords,
                                            GeneratorUtils::kebabCase($field),
                                            $fieldSnakeCase,
                                            GeneratorUtils::cleanLowerCase($field),
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/select')
                                    );
                                    break;
                                case 'datalist':
                                    foreach ($arrOption as $arrOptionIndex => $value) {
                                        $options .= "<option value=\"" . $value . "\">$value</option>";

                                        if ($arrOptionIndex + 1 != $totalOptions) {
                                            $options .= "\n\t\t";
                                        } else {
                                            $options .= "\t\t\t";
                                        }
                                    }

                                    $template .= str_replace(
                                        [
                                            '{{fieldKebabCase}}',
                                            '{{fieldCamelCase}}',
                                            '{{fieldUcWords}}',
                                            '{{fieldSnakeCase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                            '{{value}}',
                                        ],
                                        [
                                            GeneratorUtils::kebabCase($field),
                                            GeneratorUtils::singularCamelCase($field),
                                            $fieldUcWords,
                                            $fieldSnakeCase,
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}",
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/datalist')
                                    );
                                    break;
                                default:
                                    // radio
                                    $options .= "\t<div class=\"col-md-6\">\n\t<p>$fieldUcWords</p>\n";

                                    foreach ($arrOption as $value) {
                                        $options .= str_replace(
                                            [
                                                '{{fieldSnakeCase}}',
                                                '{{optionKebabCase}}',
                                                '{{value}}',
                                                '{{optionLowerCase}}',
                                                '{{checked}}',
                                                '{{nullable}}',
                                            ],
                                            [
                                                $fieldSnakeCase,
                                                GeneratorUtils::singularKebabCase($value),
                                                $value,
                                                GeneratorUtils::cleanSingularLowerCase($value),
                                                "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$field == '$value' ? 'checked' : (old('$field') == '$value' ? 'checked' : '') }}",
                                                $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            ],
                                            GeneratorUtils::getTemplate('views/forms/radio')
                                        );
                                    }

                                    $options .= "\t</div>\n";

                                    $template .= $options;
                                    break;
                            }
                            break;
                        case 'foreignId':
                            // remove '/' or sub folders
                            $constrainModel = GeneratorUtils::setModelName($request['constrains'][$i], 'default');

                            $constrainSingularCamelCase = GeneratorUtils::singularCamelCase($constrainModel);

                            $columnAfterId = GeneratorUtils::getColumnAfterId($constrainModel);

                            $options = "
                        @foreach ($" . GeneratorUtils::pluralCamelCase($constrainModel) . " as $$constrainSingularCamelCase)
                            <option value=\"{{ $" . $constrainSingularCamelCase . "->id }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == $" . $constrainSingularCamelCase . "->id ? 'selected' : (old('$fieldSnakeCase') == $" . $constrainSingularCamelCase . "->id ? 'selected' : '') }}>
                                {{ $" . $constrainSingularCamelCase . "->$columnAfterId }}
                            </option>
                        @endforeach";

                            switch ($request['input_types'][$i]) {
                                case 'datalist':
                                    $template .= str_replace(
                                        [
                                            '{{fieldKebabCase}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldUcWords}}',
                                            '{{fieldCamelCase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                            '{{value}}',
                                        ],
                                        [
                                            GeneratorUtils::KebabCase($field),
                                            $fieldSnakeCase,
                                            GeneratorUtils::cleanSingularUcWords($constrainModel),
                                            GeneratorUtils::singularCamelCase($field),
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}",
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/datalist')
                                    );
                                    break;
                                default:
                                    // select
                                    $template .= str_replace(
                                        [
                                            '{{fieldKebabCase}}',
                                            '{{fieldUcWords}}',
                                            '{{fieldSpaceLowercase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                            '{{fieldSnakeCase}}',
                                        ],
                                        [
                                            GeneratorUtils::singularKebabCase($field),
                                            GeneratorUtils::cleanSingularUcWords($constrainModel),
                                            GeneratorUtils::cleanSingularLowerCase($constrainModel),
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            $fieldSnakeCase,
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/select')
                                    );
                                    break;
                            }
                            break;
                        case 'year':
                            $firstYear = is_int(config('generator.format.first_year')) ? config('generator.format.first_year') : 1900;

                            /**
                             * Will generate something like:
                             *
                             * <select class="form-select" name="year" id="year" class="form-control" required>
                             * <option value="" selected disabled>-- {{ __('Select year') }} --</option>
                             *  @foreach (range(1900, strftime('%Y', time())) as $year)
                             *     <option value="{{ $year }}"
                             *        {{ isset($book) && $book->year == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                             *      {{ $year }}
                             * </option>
                             *  @endforeach
                             * </select>
                             */
                            $options = "
                        @foreach (range($firstYear, strftime(\"%Y\", time())) as \$year)
                            <option value=\"{{ \$year }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == \$year ? 'selected' : (old('$fieldSnakeCase') == \$year ? 'selected' : '') }}>
                                {{ \$year }}
                            </option>
                        @endforeach";

                            switch ($request['input_types'][$i]) {
                                case 'datalist':
                                    $template .= str_replace(
                                        [
                                            '{{fieldKebabCase}}',
                                            '{{fieldCamelCase}}',
                                            '{{fieldUcWords}}',
                                            '{{fieldSnakeCase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                            '{{value}}',
                                        ],
                                        [
                                            GeneratorUtils::singularKebabCase($field),
                                            GeneratorUtils::singularCamelCase($field),
                                            $fieldUcWords,
                                            $fieldSnakeCase,
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}",
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/datalist')
                                    );
                                    break;
                                default:
                                    $template .= str_replace(
                                        [
                                            '{{fieldUcWords}}',
                                            '{{fieldKebabCase}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldSpaceLowercase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                        ],
                                        [
                                            GeneratorUtils::cleanUcWords($field),
                                            GeneratorUtils::kebabCase($field),
                                            $fieldSnakeCase,
                                            GeneratorUtils::cleanLowerCase($field),
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/select')
                                    );
                                    break;
                            }
                            break;
                        case 'boolean':
                            switch ($request['input_types'][$i]) {
                                case 'select':
                                    // select
                                    $options = "<option value=\"0\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'selected' : (old('$fieldSnakeCase') == '0' ? 'selected' : '') }}>{{ __('True') }}</option>\n\t\t\t\t<option value=\"1\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'selected' : (old('$fieldSnakeCase') == '1' ? 'selected' : '') }}>{{ __('False') }}</option>";

                                    $template .= str_replace(
                                        [
                                            '{{fieldUcWords}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldKebabCase}}',
                                            '{{fieldSpaceLowercase}}',
                                            '{{options}}',
                                            '{{nullable}}',
                                        ],
                                        [
                                            GeneratorUtils::cleanUcWords($field),
                                            $fieldSnakeCase,
                                            GeneratorUtils::kebabCase($field),
                                            GeneratorUtils::cleanLowerCase($field),
                                            $options,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/select')
                                    );
                                    break;

                                default:
                                    // radio
                                    $options = "\t<div class=\"col-md-6\">\n\t<p>$fieldUcWords</p>";

                                    /**
                                     * will generate something like:
                                     *
                                     * <div class="form-check mb-2">
                                     *  <input class="form-check-input" type="radio" name="is_active" id="is_active-1" value="1" {{ isset($product) && $product->is_active == '1' ? 'checked' : (old('is_active') == '1' ? 'checked' : '') }}>
                                     *     <label class="form-check-label" for="is_active-1">True</label>
                                     * </div>
                                     *  <div class="form-check mb-2">
                                     *    <input class="form-check-input" type="radio" name="is_active" id="is_active-0" value="0" {{ isset($product) && $product->is_active == '0' ? 'checked' : (old('is_active') == '0' ? 'checked' : '') }}>
                                     *      <label class="form-check-label" for="is_active-0">False</label>
                                     * </div>
                                     */
                                    $options .= "
                                    <div class=\"form-check mb-2\">
                                        <input class=\"form-check-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-1\" value=\"1\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'checked' : (old('$fieldSnakeCase') == '1' ? 'checked' : '') }}>
                                        <label class=\"form-check-label\" for=\"$fieldSnakeCase-1\">True</label>
                                    </div>
                                    <div class=\"form-check mb-2\">
                                        <input class=\"form-check-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-0\" value=\"0\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'checked' : (old('$fieldSnakeCase') == '0' ? 'checked' : '') }}>
                                        <label class=\"form-check-label\" for=\"$fieldSnakeCase-0\">False</label>
                                    </div>\n";

                                    $options .= "\t</div>\n";

                                    $template .= $options;
                                    break;
                            }
                            break;

                        default:
                            // input form
                            if ($request['default_values'][$i]) {
                                $formatValue = "{{ (isset($$modelNameSingularCamelCase) ? $$modelNameSingularCamelCase->$fieldSnakeCase : old('$fieldSnakeCase')) ? old('$fieldSnakeCase') : '" . $request['default_values'][$i] . "' }}";
                            } else {
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) ? $$modelNameSingularCamelCase->$fieldSnakeCase : old('$fieldSnakeCase') }}";
                            }

                            switch ($request['input_types'][$i]) {
                                case 'datetime-local':
                                    /**
                                     * Will generate something like:
                                     *
                                     * {{ isset($book) && $book->datetime ? $book->datetime->format('Y-m-d\TH:i') : old('datetime') }}
                                     */
                                    $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d\TH:i') : old('$fieldSnakeCase') }}";

                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue,
                                        date: 1
                                    );
                                    break;
                                case 'date':
                                    /**
                                     * Will generate something like:
                                     *
                                     * {{ isset($book) && $book->date ? $book->date->format('Y-m-d') : old('date') }}
                                     */
                                    $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d') : old('$fieldSnakeCase') }}";

                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue,
                                        date: 1
                                    );
                                    break;
                                case 'time':
                                    /**
                                     * Will generate something like:
                                     *
                                     * {{ isset($book) ? $book->time->format('H:i') : old('time') }}
                                     */
                                    $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('H:i') : old('$fieldSnakeCase') }}";

                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue,
                                        date: 1
                                    );
                                    break;
                                case 'week':
                                    /**
                                     * Will generate something like:
                                     *
                                     * {{ isset($book) ? $book->week->format('Y-\WW') : old('week') }}
                                     */
                                    $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-\WW') : old('$fieldSnakeCase') }}";

                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue,
                                        date: 1
                                    );
                                    break;
                                case 'month':
                                    /**
                                     * Will generate something like:
                                     *
                                     * {{ isset($book) ? $book->month->format('Y-\WW') : old('month') }}
                                     */
                                    $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m') : old('$fieldSnakeCase') }}";

                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue,
                                        date: 1
                                    );
                                    break;
                                case 'textarea':
                                    // textarea
                                    $template .= str_replace(
                                        [
                                            '{{fieldKebabCase}}',
                                            '{{fieldUppercase}}',
                                            '{{modelName}}',
                                            '{{nullable}}',
                                            '{{fieldSnakeCase}}',

                                        ],
                                        [
                                            GeneratorUtils::kebabCase($field),
                                            $fieldUcWords,
                                            $modelNameSingularCamelCase,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            $fieldSnakeCase,
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/textarea')
                                    );
                                    break;
                                case 'file':

                                    $template .= str_replace(
                                        [
                                            '{{modelCamelCase}}',
                                            '{{fieldPluralSnakeCase}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldLowercase}}',
                                            '{{fieldUcWords}}',
                                            '{{nullable}}',
                                            '{{uploadPathPublic}}',
                                            '{{fieldKebabCase}}',
                                            '{{defaultImage}}',
                                            '{{defaultImageCodeForm}}',
                                        ],
                                        [
                                            $modelNameSingularCamelCase,
                                            GeneratorUtils::pluralSnakeCase($field),
                                            str()->snake($field),
                                            GeneratorUtils::cleanSingularLowerCase($field),
                                            $fieldUcWords,
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            config('generator.image.path') == 'storage' ? "storage/uploads" : "uploads",
                                            str()->kebab($field),
                                            "",
                                            "",
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/image')
                                    );
                                    break;
                                case 'range':
                                    $template .= str_replace(
                                        [
                                            '{{fieldSnakeCase}}',
                                            '{{fieldUcWords}}',
                                            '{{fieldKebabCase}}',
                                            '{{nullable}}',
                                            '{{min}}',
                                            '{{max}}',
                                            '{{step}}',
                                        ],
                                        [
                                            GeneratorUtils::singularSnakeCase($field),
                                            $fieldUcWords,
                                            GeneratorUtils::singularKebabCase($field),
                                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                                            $request['min_lengths'][$i],
                                            $request['max_lengths'][$i],
                                            $request['steps'][$i] ? 'step="' . $request['steps'][$i] . '"' : '',
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/range')
                                    );
                                    break;
                                case 'hidden':
                                    $template .= '<input type="hidden" name="' . $fieldSnakeCase . '" value="' . $request['default_values'][$i] . '">';
                                    break;
                                case 'password':
                                    $template .= str_replace(
                                        [
                                            '{{fieldUcWords}}',
                                            '{{fieldSnakeCase}}',
                                            '{{fieldKebabCase}}',
                                            '{{model}}',
                                        ],
                                        [
                                            $fieldUcWords,
                                            $fieldSnakeCase,
                                            GeneratorUtils::singularKebabCase($field),
                                            $modelNameSingularCamelCase,
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/input-password')
                                    );
                                    break;
                                default:
                                    $template .= $this->setInputTypeTemplate(
                                        request: [
                                            'input_types' => $request['input_types'][$i],
                                            'requireds' => $request['requireds'][$i],
                                        ],
                                        model: $model,
                                        field: $field->code,
                                        formatValue: $formatValue
                                    );
                                    break;
                            }
                            break;
                    }
                }
            }
        }

        $template .= "</div>";

        // create a blade file
        switch ($path) {
            case '':
                GeneratorUtils::checkFolder(resource_path("/views/admin/$modelNamePluralKebabCase/include"));
                file_put_contents(resource_path("/views/admin/$modelNamePluralKebabCase/include/form.blade.php"), $template);
                break;
            default:
                $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelNamePluralKebabCase/include");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/form.blade.php", $template);
                break;
        }
    }

    public function reGenerate($id)
    {
        $module = Module::find($id);
        $model = GeneratorUtils::setModelName($module->name);
        $path = GeneratorUtils::getModelLocation($module->name);
        $code = GeneratorUtils::setModelName($module->code);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($code);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($code);

        $template = "<div class=\"row mb-2\">\n";


        foreach ($module->fields as $i => $field) {
            $field->name = GeneratorUtils::singularSnakeCase($field->name);
            $field->code = !empty($field->code) ?  GeneratorUtils::singularSnakeCase($field->code) : GeneratorUtils::singularSnakeCase($field->name);

            if ($field->input !== 'no-input') {
                $fieldSnakeCase = str($field->code)->snake();
                $fieldUcWords = GeneratorUtils::cleanUcWords($field->name);

                switch ($field->type) {
                    case 'enum':
                        $options = "";

                        $arrOption = explode('|', $field->select_option);

                        $totalOptions = count($arrOption);

                        switch ($field->input) {
                            case 'select':
                                // select
                                foreach ($arrOption as $arrOptionIndex => $value) {


                                    $multiple = '';
                                    if ($field->is_multi) {
                                        $multiple = "multiple";
                                        if ($field->default_value) {
                                            $options .= <<<BLADE
                                        <option value="$value" {{ isset(\$$modelNameSingularCamelCase) && (is_array( json_decode(\$$modelNameSingularCamelCase->$fieldSnakeCase)) ?in_array('$value', json_decode(\$$modelNameSingularCamelCase->$fieldSnakeCase)) : \$$modelNameSingularCamelCase->$fieldSnakeCase == '$value') ? 'selected' :'' }}>$value</option>
                                        BLADE;
                                        } else {
                                            $options .= <<<BLADE
                                        <option value="$value" {{ isset(\$$modelNameSingularCamelCase) && (is_array( json_decode(\$$modelNameSingularCamelCase->$fieldSnakeCase)) ?in_array('$value', json_decode(\$$modelNameSingularCamelCase->$fieldSnakeCase)) : \$$modelNameSingularCamelCase->$fieldSnakeCase == '$value')  ? 'selected' :'' }}>$value</option>
                                        BLADE;
                                        }
                                    }else{
                                        if ($field->default_value) {
                                            $options .= <<<BLADE
                                        <option value="$value" {{ isset(\$$modelNameSingularCamelCase) && \$$modelNameSingularCamelCase->$fieldSnakeCase == '$value' ? 'selected' : ('$field->default_value' == '$value' ? 'selected' : '') }}>$value</option>
                                        BLADE;
                                        } else {
                                            $options .= <<<BLADE
                                        <option value="$value" {{ isset(\$$modelNameSingularCamelCase) && \$$modelNameSingularCamelCase->$fieldSnakeCase == '$value' ? 'selected' : ('$field->default_value' == '$value' ? 'selected' : '') }}>$value</option>
                                        BLADE;
                                        }
                                    }


                                    if ($arrOptionIndex + 1 != $totalOptions) {
                                        $options .= "\n\t\t";
                                    } else {
                                        $options .= "\t\t\t";
                                    }
                                }

                                $template .= str_replace(
                                    [
                                        '{{fieldUcWords}}',
                                        '{{fieldKebabCase}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldSpaceLowercase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                        '{{multiple}}'
                                    ],
                                    [
                                        $fieldUcWords,
                                        GeneratorUtils::kebabCase($field->name),
                                        $field->is_multi ? $fieldSnakeCase ."[]" : $fieldSnakeCase ,
                                        GeneratorUtils::cleanLowerCase($field->name),
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        $multiple
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/select')
                                );
                                break;
                            case 'datalist':
                                foreach ($arrOption as $arrOptionIndex => $value) {
                                    $options .= "<option value=\"" . $value . "\">$value</option>";

                                    if ($arrOptionIndex + 1 != $totalOptions) {
                                        $options .= "\n\t\t";
                                    } else {
                                        $options .= "\t\t\t";
                                    }
                                }

                                $d = '';
                                if (isset($field->default_value)) {
                                    $d = $field->default_value;
                                }

                                $template .= str_replace(
                                    [
                                        '{{fieldKebabCase}}',
                                        '{{fieldCamelCase}}',
                                        '{{fieldUcWords}}',
                                        '{{fieldSnakeCase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                        '{{value}}',
                                    ],
                                    [
                                        GeneratorUtils::kebabCase($field->name),
                                        GeneratorUtils::singularCamelCase($field->name),
                                        $fieldUcWords,
                                        $fieldSnakeCase,
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : $d }}",
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/datalist')
                                );
                                break;
                            default:
                                // radio

                                $d = '';
                                if (isset($field->default_value)) {
                                    $d = $field->default_value;
                                }

                                $options .= "\t<div class=\"col-md-12\">\n\t<p>$fieldUcWords</p>\n";

                                foreach ($arrOption as $value) {
                                    $options .= str_replace(
                                        [
                                            '{{fieldSnakeCase}}',
                                            '{{optionKebabCase}}',
                                            '{{value}}',
                                            '{{optionLowerCase}}',
                                            '{{checked}}',
                                            '{{nullable}}',
                                        ],
                                        [
                                            $fieldSnakeCase,
                                            GeneratorUtils::singularKebabCase($value),
                                            $value,
                                            GeneratorUtils::cleanSingularLowerCase($value),
                                            "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$field->name == '$value' ? 'checked' : ('$d' == '$value' ? 'checked' : '') }}",
                                            $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        ],
                                        GeneratorUtils::getTemplate('views/forms/radio')
                                    );
                                }

                                $options .= "\t</div>\n";

                                $template .= $options;
                                break;
                        }
                        break;
                    case 'foreignId':
                        // remove '/' or sub folders
                        $constrainModel = GeneratorUtils::setModelName($field->constrain, 'default');

                        $constrainSingularCamelCase = GeneratorUtils::singularCamelCase($constrainModel);

                        $columnAfterId = $field->attribute;

                        $options = "
                        @foreach ($" . GeneratorUtils::pluralCamelCase($constrainModel) . " as $$constrainSingularCamelCase)
                            <option value=\"{{ $" . $constrainSingularCamelCase . "->id }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == $" . $constrainSingularCamelCase . "->id ? 'selected' : (old('$fieldSnakeCase') == $" . $constrainSingularCamelCase . "->id ? 'selected' : '') }}>
                                {{ $" . $constrainSingularCamelCase . "->$columnAfterId }}
                            </option>
                        @endforeach";

                        switch ($field->input) {
                            case 'datalist':
                                $template .= str_replace(
                                    [
                                        '{{fieldKebabCase}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldUcWords}}',
                                        '{{fieldCamelCase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                        '{{value}}',
                                    ],
                                    [
                                        GeneratorUtils::KebabCase($field->name),
                                        $fieldSnakeCase,
                                        GeneratorUtils::cleanSingularUcWords($constrainModel),
                                        GeneratorUtils::singularCamelCase($field->name),
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}",
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/datalist')
                                );
                                break;
                            default:
                                // select
                                $template .= str_replace(
                                    [
                                        '{{fieldKebabCase}}',
                                        '{{fieldUcWords}}',
                                        '{{fieldSpaceLowercase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                        '{{fieldSnakeCase}}',
                                        '{{multiple}}'
                                    ],
                                    [
                                        GeneratorUtils::singularKebabCase($field->name),
                                        GeneratorUtils::cleanSingularUcWords($constrainModel),
                                        GeneratorUtils::cleanSingularLowerCase($constrainModel),
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        $fieldSnakeCase,
                                        ''
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/select')
                                );
                                break;
                        }
                        break;
                    case 'year':
                        $firstYear = is_int(config('generator.format.first_year')) ? config('generator.format.first_year') : 1900;

                        /**
                         * Will generate something like:
                         *
                         * <select class="form-select" name="year" id="year" class="form-control" required>
                         * <option value="" selected disabled>-- {{ __('Select year') }} --</option>
                         *  @foreach (range(1900, strftime('%Y', time())) as $year)
                         *     <option value="{{ $year }}"
                         *        {{ isset($book) && $book->year == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                         *      {{ $year }}
                         * </option>
                         *  @endforeach
                         * </select>
                         */
                        $options = "
                        @foreach (range($firstYear, strftime(\"%Y\", time())) as \$year)
                            <option value=\"{{ \$year }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == \$year ? 'selected' : (old('$fieldSnakeCase') == \$year ? 'selected' : '') }}>
                                {{ \$year }}
                            </option>
                        @endforeach";

                        switch ($field->input) {
                            case 'datalist':
                                $template .= str_replace(
                                    [
                                        '{{fieldKebabCase}}',
                                        '{{fieldCamelCase}}',
                                        '{{fieldUcWords}}',
                                        '{{fieldSnakeCase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                        '{{value}}',
                                    ],
                                    [
                                        GeneratorUtils::singularKebabCase($field->name),
                                        GeneratorUtils::singularCamelCase($field->name),
                                        $fieldUcWords,
                                        $fieldSnakeCase,
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}",
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/datalist')
                                );
                                break;
                            default:
                                $template .= str_replace(
                                    [
                                        '{{fieldUcWords}}',
                                        '{{fieldKebabCase}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldSpaceLowercase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                    ],
                                    [
                                        GeneratorUtils::cleanUcWords($field->name),
                                        GeneratorUtils::kebabCase($field->name),
                                        $fieldSnakeCase,
                                        GeneratorUtils::cleanLowerCase($field->name),
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/select')
                                );
                                break;
                        }
                        break;
                    case 'boolean':
                        switch ($field->input) {
                            case 'select':
                                // select
                                if (isset($field->default_value)) {
                                    $options = "<option value=\"0\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'selected' : ($field->default_value == 0 ? 'selected' : '') }}>{{ __('False') }}</option>\n\t\t\t\t
                                                    <option value=\"1\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'selected' : ($field->default_value == 1 ? 'selected' : '') }}>{{ __('True') }}</option>";
                                } else {
                                    $options = "<option value=\"0\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'selected' : (old('$fieldSnakeCase') == '0' ? 'selected' : '') }}>{{ __('False') }}</option>\n\t\t\t\t
                                                    <option value=\"1\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'selected' : (old('$fieldSnakeCase') == '1' ? 'selected' : '') }}>{{ __('True') }}</option>";
                                }

                                $template .= str_replace(
                                    [
                                        '{{fieldUcWords}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldKebabCase}}',
                                        '{{fieldSpaceLowercase}}',
                                        '{{options}}',
                                        '{{nullable}}',
                                    ],
                                    [
                                        GeneratorUtils::cleanUcWords($field->name),
                                        $fieldSnakeCase,
                                        GeneratorUtils::kebabCase($field->name),
                                        GeneratorUtils::cleanLowerCase($field->name),
                                        $options,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/select')
                                );
                                break;

                            default:
                                // radio
                                $options = "\t<div class=\"col-md-6\">\n\t<p>$fieldUcWords</p>";

                                /**
                                 * will generate something like:
                                 *
                                 * <div class="form-check mb-2">
                                 *  <input class="form-check-input" type="radio" name="is_active" id="is_active-1" value="1" {{ isset($product) && $product->is_active == '1' ? 'checked' : (old('is_active') == '1' ? 'checked' : '') }}>
                                 *     <label class="form-check-label" for="is_active-1">True</label>
                                 * </div>
                                 *  <div class="form-check mb-2">
                                 *    <input class="form-check-input" type="radio" name="is_active" id="is_active-0" value="0" {{ isset($product) && $product->is_active == '0' ? 'checked' : (old('is_active') == '0' ? 'checked' : '') }}>
                                 *      <label class="form-check-label" for="is_active-0">False</label>
                                 * </div>
                                 */

                                if (isset($field->default_value)) {
                                    $options .= "
                                        <div class=\"custom-controls-stacked\">
                                            <label class=\"custom-control custom-radio\" for=\"$fieldSnakeCase-1\">
                                            <input class=\"custom-control-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-1\" value=\"1\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'checked' : ($field->default_value == 1 ? 'checked' : '') }}>
                                            <span class=\"custom-control-label\">True</span></label>

                                        <label class=\"custom-control custom-radio\" for=\"$fieldSnakeCase-0\">
                                            <input class=\"custom-control-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-0\" value=\"0\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'checked' : ($field->default_value == 0 ? 'checked' : '') }}>
                                            <span class=\"custom-control-label\">False</span></label>
                                        </div>\n";
                                } else {
                                    $options .= "
                                        <div class=\"custom-controls-stacked\">
                                            <label class=\"custom-control custom-radio\" for=\"$fieldSnakeCase-1\">
                                            <input class=\"custom-control-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-1\" value=\"1\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'checked' : '' }}>
                                            <span class=\"custom-control-label\">True</span></label>

                                        <label class=\"custom-control custom-radio\" for=\"$fieldSnakeCase-0\">
                                            <input class=\"custom-control-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-0\" value=\"0\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'checked' : '' }}>
                                            <span class=\"custom-control-label\">False</span></label>
                                        </div>\n";

                                }


                                $options .= "\t</div>\n";

                                $template .= $options;
                                break;
                        }
                        break;

                    case 'multi':



                        $template .= '<div class="multi-options col-12">
                        <div class="attr_header row flex justify-content-end my-5 align-items-end">
                            <input title="Reset form" class="btn btn-success" id="add_new_tr_' . $field->id . '" type="button" value="+ Add">
                        </div>';

                        $template .= '
                        @if(isset($'.$modelNameSingularCamelCase.')  && $' . $modelNameSingularCamelCase . '->' . $fieldSnakeCase . '!= null )
                        @php

                        $ar = json_decode($'. $modelNameSingularCamelCase . '->' . $fieldSnakeCase  .');
                        $index = 0;
                        @endphp
                        @endif

                        <input type="hidden"  name="' . $field->name . '" />

                        <table class="table table-bordered align-items-center mb-0" id="tbl-field-' . $field->id . '">
                        <thead>';

                        foreach ($field->multis as $key => $value) {
                            $template .= '<th>' . $value->name . '</th>';
                        }

                        $template .= '
                        <th></th>
                        </thead>
                        <tbody>
                        @if(isset($'.$modelNameSingularCamelCase.')  && $' . $modelNameSingularCamelCase . '->' . $fieldSnakeCase . '!= null )

                        @foreach( $ar as $item )
                        @php
                            $index++;
                        @endphp
                        ';
                        // foreach ($field->multi as $key => $value) {
                            $template .= '<tr draggable="true" containment="tbody" ondragstart="dragStart()" ondragover="dragOver()" style="cursor: move;">';
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
                                        $template .= ' <td>
                                        <div class="input-box">
                                            <input type="' . $value->type . '" name="' . $field->code . '[{{ $index }}][' . $value->name . ']"
                                                class="form-control google-input"
                                                placeholder="' . $value->name . '" value="{{ $item->'.$value->name.' }}" required>
                                        </div>
                                    </td>
                                    ';
                                        break;
                                    case 'image':
                                        $template .= ' <td>
                                            <div class="input-box">
                                                <input type="file" name="' . $field->code . '[{{ $index }}][' . $value->name . ']"
                                                    class="form-control google-input"
                                                    placeholder="' . $value->name . '" required>
                                            </div>
                                        </td>
                                        ';
                                        break;

                                    case 'textarea':
                                        $template .= ' <td>
                                            <div class="input-box">

                                            <textarea name="' . $field->code . '[{{ $index }}][' . $value->name . ']"  class="google-input"  placeholder="' . $value->name . '">{{ $item->'.$value->name.' }}</textarea>

                                            </div>
                                        </td>
                                        ';
                                        break;

                                    case 'range':
                                        $template .= '<td>
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
                                        $template .= '<td>
                                    <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio" for="' . $value->name . '-1">
                                        <input @checked( $item->'.$value->name.' == "1" ) class="custom-control-input" type="radio" name="' . $field->code . '[{{ $index }}][' . $value->name . ']" id="' . $value->name . '-1" value="1">
                                        <span class="custom-control-label">True</span>
                                    </label>

                                    <label class="custom-control custom-radio" for="' . $value->name . '-0">
                                        <input @checked( $item->'.$value->name.' == "0" )  class="custom-control-input" type="radio" name="' . $field->code . '[{{ $index }}][' . $value->name . ']" id="' . $value->name . '-0" value="0">
                                        <span class="custom-control-label">False</span>
                                    </label>
                                </div>
                                                </td>
                                                            ';
                                        break;
                                    case 'select':

                                        $arrOption = explode('|', $value->select_options);

                                        $totalOptions = count($arrOption);
                                        $template .= '<td><div class="input-box">';
                                        $template .= ' <select name="' . $field->code . '[{{ $index }}][' . $value->name . ']" class="form-select  google-input multi-type" required="">';

                                        foreach ($arrOption as $arrOptionIndex => $value2) {
                                            $template .= '<option @selected( $item->'.$value->name.' == "'.$value2.'" ) value="' . $value2 . '" >' . $value2 . '</option>';

                                        }
                                        $template .= '</select>';
                                        $template .= '</div></td>';
                                        break;
                                        case 'foreignId':

                                            $arrOption = explode('|', $value->select_options);

                                            $totalOptions = count($arrOption);
                                            $template .= '<td><div class="input-box">';
                                            $template .= ' <select name="' . $field->code . '[{{ $index }}][' . $value->name . ']" class="form-select  google-input multi-type" required="">';

                                            $template.= '@foreach( \\App\\Models\\'.GeneratorUtils::singularPascalCase($value->constrain).'::all() as $item2 )';
                                                $template .= '<option @selected( $item->'.$value->name.' == "$item2->'.$value->attribute . '" )  value="{{ $item2->'.$value->attribute . '}}" >{{ $item2->'.$value->attribute . '}}</option>';

                                            $template.= '@endforeach';
                                            $template .= '</select>';
                                            $template .= '</div></td>';
                                            break;

                                    default:
                                        # code...
                                        break;
                                }

                            }
                            $template .= '
                            <td>
                                <div class="input-box">

                                    <button type="button"
                                        class="btn btn-outline-danger btn-xs btn-delete">
                                        x
                                    </button>
                                </div>
                            </td>
                            </tr>';
                        // }
                        $template .= '
                        @endforeach
                        @endif
                        </tbody>
                        </table>
                        </div>
                        ';


                        break;

                    default:
                        // input form
                        if ($field->default_value) {
                            $formatValue = "{{ (isset($$modelNameSingularCamelCase) ? $$modelNameSingularCamelCase->$fieldSnakeCase : old('$fieldSnakeCase')) ? old('$fieldSnakeCase') : '" . $field->default_value . "' }}";
                        } else {
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) ? $$modelNameSingularCamelCase->$fieldSnakeCase : old('$fieldSnakeCase') }}";
                        }

                        switch ($field->input) {
                            case 'datetime-local':
                                /**
                                 * Will generate something like:
                                 *
                                 * {{ isset($book) && $book->datetime ? $book->datetime->format('Y-m-d\TH:i') : old('datetime') }}
                                 */
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d\TH:i') : old('$fieldSnakeCase') }}";

                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    date: 1,
                                    label: $field->name
                                );
                                break;
                            case 'date':
                                /**
                                 * Will generate something like:
                                 *
                                 * {{ isset($book) && $book->date ? $book->date->format('Y-m-d') : old('date') }}
                                 */
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d') : old('$fieldSnakeCase') }}";

                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    date: 1,
                                    label: $field->name
                                );
                                break;
                            case 'time':
                                /**
                                 * Will generate something like:
                                 *
                                 * {{ isset($book) ? $book->time->format('H:i') : old('time') }}
                                 */
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('H:i') : old('$fieldSnakeCase') }}";

                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    date: 1,
                                    label: $field->name
                                );
                                break;
                            case 'week':
                                /**
                                 * Will generate something like:
                                 *
                                 * {{ isset($book) ? $book->week->format('Y-\WW') : old('week') }}
                                 */
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-\WW') : old('$fieldSnakeCase') }}";

                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    date: 1,
                                    label: $field->name
                                );
                                break;
                            case 'month':
                                /**
                                 * Will generate something like:
                                 *
                                 * {{ isset($book) ? $book->month->format('Y-\WW') : old('month') }}
                                 */
                                $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m') : old('$fieldSnakeCase') }}";

                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    date: 1,
                                    label: $field->name
                                );
                                break;
                            case 'textarea':
                                // textarea
                                $template .= str_replace(
                                    [
                                        '{{fieldKebabCase}}',
                                        '{{fieldUppercase}}',
                                        '{{modelName}}',
                                        '{{nullable}}',
                                        '{{fieldSnakeCase}}',

                                    ],
                                    [
                                        GeneratorUtils::kebabCase($field->name),
                                        $fieldUcWords,
                                        $modelNameSingularCamelCase,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        $fieldSnakeCase,
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/textarea')
                                );
                                break;
                            case 'file':
                            case 'image':

                                $template .= str_replace(
                                    [
                                        '{{modelCamelCase}}',
                                        '{{fieldPluralSnakeCase}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldLowercase}}',
                                        '{{fieldUcWords}}',
                                        '{{nullable}}',
                                        '{{uploadPathPublic}}',
                                        '{{fieldKebabCase}}',
                                        '{{defaultImage}}',
                                        '{{defaultImageCodeForm}}',
                                    ],
                                    [
                                        $modelNameSingularCamelCase,
                                        GeneratorUtils::pluralSnakeCase($field->name),
                                        str()->snake($field->code),
                                        GeneratorUtils::cleanSingularLowerCase($field->name),
                                        $fieldUcWords,
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        config('generator.image.path') == 'storage' ? "storage/uploads" : "uploads",
                                        str()->kebab($field->name),
                                        "",
                                        "",
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/image')
                                );
                                break;
                            case 'range':
                                $template .= str_replace(
                                    [
                                        '{{fieldSnakeCase}}',
                                        '{{fieldUcWords}}',
                                        '{{fieldKebabCase}}',
                                        '{{nullable}}',
                                        '{{min}}',
                                        '{{max}}',
                                        '{{step}}',
                                        '{{value}}'
                                    ],
                                    [
                                        GeneratorUtils::singularSnakeCase($field->code),
                                        $fieldUcWords,
                                        GeneratorUtils::singularKebabCase($field->name),
                                        $field->required == 'yes' || $field->required == 'on' ? ' required' : '',
                                        $field->min_length,
                                        $field->max_length,
                                        $field->steps ? 'step="' . $field->steps . '"' : '',
                                        $formatValue
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/range')
                                );
                                break;
                            case 'hidden':
                                $template .= '<input type="hidden" name="' . $fieldSnakeCase . '" value="' . $field->default_value . '">';
                                break;
                            case 'password':
                                $template .= str_replace(
                                    [
                                        '{{fieldUcWords}}',
                                        '{{fieldSnakeCase}}',
                                        '{{fieldKebabCase}}',
                                        '{{model}}',
                                    ],
                                    [
                                        $fieldUcWords,
                                        $fieldSnakeCase,
                                        GeneratorUtils::singularKebabCase($field->name),
                                        $modelNameSingularCamelCase,
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/input-password')
                                );
                                break;
                            default:
                                $template .= $this->setInputTypeTemplate(
                                    request: [
                                        'input_types' => $field->input,
                                        'requireds' => $field->required,
                                    ],
                                    model: $model,
                                    field: $field->code,
                                    formatValue: $formatValue,
                                    label: $field->name
                                );
                                break;
                        }
                        break;
                }
            }
        }


        $template .= "</div>";

        // create a blade file
        switch ($path) {
            case '':
                GeneratorUtils::checkFolder(resource_path("/views/admin/$modelNamePluralKebabCase/include"));
                file_put_contents(resource_path("/views/admin/$modelNamePluralKebabCase/include/form.blade.php"), $template);
                break;
            default:
                $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelNamePluralKebabCase/include");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/form.blade.php", $template);
                break;
        }
    }

    /**
     * Set input type from .stub file.
     *
     * @param string $field
     * @param array $request
     * @param string $model
     * @param string $formatValue
     * @return string
     */
    public function setInputTypeTemplate(string $field, array $request, string $model, string $formatValue, $date = 0,string $label = '', ): string
    {
        if ($date == 1) {
            return str_replace(
                [
                    '{{fieldKebabCase}}',
                    '{{fieldUcWords}}',
                    '{{fieldSnakeCase}}',
                    '{{type}}',
                    '{{value}}',
                    '{{nullable}}',
                ],
                [
                    GeneratorUtils::singularKebabCase($label),
                    GeneratorUtils::cleanUcWords($label),
                    str($field)->snake(),
                    $request['input_types'],
                    $formatValue,
                    $request['requireds'] == 'yes' ? ' required' : '',
                ],
                GeneratorUtils::getTemplate('views/forms/input-date')
            );
        }
        return str_replace(
            [
                '{{fieldKebabCase}}',
                '{{fieldUcWords}}',
                '{{fieldSnakeCase}}',
                '{{type}}',
                '{{value}}',
                '{{nullable}}',
            ],
            [
                GeneratorUtils::singularKebabCase($label),
                GeneratorUtils::cleanUcWords($label),
                str($field)->snake(),
                $request['input_types'],
                $formatValue,
                $request['requireds'] == 'yes' ? ' required' : '',
            ],
            GeneratorUtils::getTemplate('views/forms/input')
        );
    }
}
