<?php

declare(strict_types=1);

namespace App\Routing\Registrars;

use App\Http\Controllers\Api\Cities\CityController;
use App\Http\Controllers\Api\FederalDistricts\FederalDistrictController;
use App\Http\Controllers\Api\Regions\RegionController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class CityRegistar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        $registrar->group(['prefix' => 'api/v1', 'middleware' => 'api'], function (Registrar $registrar) {

            /*****************  CITY ROUTES **************/
            $registrar->resource('cities', CityController::class);

            /*****************  REGION ROUTES **************/
            $registrar->resource('regions', RegionController::class);

            /*****************  FEDERAL DISTRICT ROUTES **************/
            $registrar->resource('federal-districts', FederalDistrictController::class);

        });
    }
}
