<?php

declare(strict_types=1);


namespace App\Routing\Registrars;

use App\Http\Controllers\Api\OrganizationController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class OrganizationRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        $registrar->group(['prefix' => 'api/v1', 'middleware' => 'api'], function (Registrar $registrar) {

            $registrar->resource('organizations', OrganizationController::class);

        });
    }
}
