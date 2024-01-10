<?php

namespace App\Services;

use App\Generators\MigrationGenerator;
use App\Generators\ModelGenerator;
use App\Generators\Views\ActionViewGenerator;
use App\Generators\Views\CreateViewGenerator;
use App\Generators\Views\FormViewGenerator;
use App\Generators\Views\ShowViewGenerator;
use App\Generators\WebControllerGenerator;
use App\Generators\RequestGenerator;
use App\Generators\WebRouteGenerator;
use App\Generators\Views\IndexViewGenerator;
use App\Generators\Views\EditViewGenerator;
use App\Generators\ViewComposerGenerator;




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

    public function reGenerateModel($id): void
    {
        (new ModelGenerator)->reGenerate($id);
    }


    public function generateMigration(array $request,$id): void
    {
        (new MigrationGenerator)->generate($request,$id);
    }

    public function reGenerateMigration($id): void
    {
        (new MigrationGenerator)->reGenerate($id);
    }

    public function generateController(array $request): void
    {
        (new WebControllerGenerator)->generate($request);
    }

    public function reGenerateController($id): void
    {
        (new WebControllerGenerator)->reGenerate($id);
    }

    public function generateRequest(array $request): void
    {
        (new RequestGenerator)->generate($request);
    }

    public function reGenerateRequest($id): void
    {
        (new RequestGenerator)->reGenerate($id);
    }

    public function generateRoute(array $request): void
    {
        (new WebRouteGenerator)->generate($request);
    }


    public function generateViews(array $request): void
    {
        (new IndexViewGenerator)->generate($request);
        (new ActionViewGenerator)->generate($request);
        (new CreateViewGenerator)->generate($request);
        (new FormViewGenerator)->generate($request);
        (new ShowViewGenerator)->generate($request);
        (new EditViewGenerator)->generate($request);
        (new ViewComposerGenerator)->generate($request);
    }

    public function reGenerateViews($id): void
    {
        (new IndexViewGenerator)->reGenerate($id);
        (new FormViewGenerator)->reGenerate($id);
        // (new ShowViewGenerator)->generate($id);
        // (new ViewComposerGenerator)->generate($id);
    }

}
