<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;

class EditViewGenerator
{
    /**
     * Generate an edit view.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['name'], 'default');
        $path = GeneratorUtils::getModelLocation($request['name']);

        $modelNamePluralUcWords = GeneratorUtils::cleanPluralUcWords($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);
        $modelNameSingularLowerCase = GeneratorUtils::cleanSingularLowerCase($model);
        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);

        $template = str_replace(
            [
                '{{modelNamePluralUcWords}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralKebabCase}}',
                '{{modelNameSingularCamelCase}}',
                '{{enctype}}',
                '{{viewPath}}',
            ],
            [
                $modelNamePluralUcWords,
                $modelNameSingularLowerCase,
                $modelNamePluralKebabCase,
                $modelNameSingularCamelCase,
                !empty($request['input_types']) && isset($request['input_types']) ? (in_array('file', $request['input_types']) ? ' enctype="multipart/form-data"' : '') : '',
                $path != '' ? str_replace('\\', '.', $path) . "." : ''
            ],
            GeneratorUtils::getTemplate('views/edit')
        );

        if ($path != '') {
            $fullPath = resource_path("/views/admin/" . strtolower($path) . "/$modelNamePluralKebabCase");

            GeneratorUtils::checkFolder($fullPath);

            file_put_contents($fullPath . "/edit.blade.php", $template);
        } else {
            GeneratorUtils::checkFolder(resource_path("/views/admin/$modelNamePluralKebabCase"));

            file_put_contents(resource_path("/views/admin/$modelNamePluralKebabCase/edit.blade.php"), $template);
        }
    }
}
