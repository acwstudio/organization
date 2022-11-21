<?php

declare(strict_types=1);


namespace App\Routing\Registrars;

use App\Http\Controllers\Api\OpenApiController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class DefaultRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        $registrar->view('/', 'welcome');

        $registrar->group(['prefix' => 'api/v1'], function (Registrar $registrar) {

            $registrar->get('spec/swagger', [OpenApiController::class, 'swagger'])->name('api.spec.swagger');

            $registrar->get('spec/redoc', [OpenApiController::class, 'redoc'])->name('api.spec.redoc');

            $registrar->get('spec/document',[OpenApiController::class,'document'])->name('api.spec.document');

        });
    }
}
