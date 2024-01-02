<?php

namespace App\Services;

use App\Generators\MigrationGenerator;
use App\Generators\ModelGenerator;
use App\Generators\WebControllerGenerator;
use App\Generators\RequestGenerator;




class GeneratorService
{
    /**
     * Generate Model.
     *
     * @param array $request
     * @return void
     */
    public function generateModel(array $request): void
    {
        (new ModelGenerator)->generate($request);
    }


    public function generateMigration(array $request): void
    {
        (new MigrationGenerator)->generate($request);
    }

    public function generateController(array $request): void
    {
        (new WebControllerGenerator)->generate($request);
    }

    public function generateRequest(array $request): void
    {
        (new RequestGenerator)->generate($request);
    }



}
