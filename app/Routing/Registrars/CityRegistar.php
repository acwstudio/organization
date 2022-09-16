<?php

declare(strict_types=1);

namespace App\Routing\Registrars;

use App\Http\Controllers\Api\Cities\CitiesRegionRelatedController;
use App\Http\Controllers\Api\Cities\CitiesRegionRelationshipsController;
use App\Http\Controllers\Api\Cities\CityController;
use App\Http\Controllers\Api\Cities\CityOrganizationsRelatedController;
use App\Http\Controllers\Api\Cities\CityOrganizationsRelationshipsController;
use App\Http\Controllers\Api\FederalDistricts\FederalDistrictController;
use App\Http\Controllers\Api\FederalDistricts\FederalDistrictRegionsRelatedController;
use App\Http\Controllers\Api\FederalDistricts\FederalDistrictRegionsRelationshipsController;
use App\Http\Controllers\Api\Regions\RegionCitiesRelatedController;
use App\Http\Controllers\Api\Regions\RegionCitiesRelationshipsController;
use App\Http\Controllers\Api\Regions\RegionController;
use App\Http\Controllers\Api\Regions\RegionsFederalDistrictRelatedController;
use App\Http\Controllers\Api\Regions\RegionsFederalDistrictRelationshipsController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class CityRegistar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        $registrar->group(['prefix' => 'api/v1', 'middleware' => 'api'], function (Registrar $registrar) {

            /*****************  CITY ROUTES **************/
            $registrar->resource('cities', CityController::class);

            // City to Organizations relations
            $registrar->get('cities/{id}/relationships/organizations',[
                CityOrganizationsRelationshipsController::class, 'index'
            ])->name('city.relationships.organizations');

            $registrar->patch('cities/{id}/relationships/organizations',[
                CityOrganizationsRelationshipsController::class, 'update'
            ])->name('city.relationships.organizations');

            $registrar->get('cities/{id}/organizations',[
                CityOrganizationsRelatedController::class, 'index'
            ])->name('city.organizations');

            // Cities to Region relations
            $registrar->get('cities/{id}/relationships/region', [
                CitiesRegionRelationshipsController::class, 'index'
            ])->name('cities.relationships.region');

            $registrar->patch('cities/{id}/relationships/region', [
                CitiesRegionRelationshipsController::class, 'update'
            ])->name('cities.relationships.region');

            $registrar->get('cities/{id}/region', [
                CitiesRegionRelatedController::class, 'index'
            ])->name('cities.region');

            /*****************  REGION ROUTES **************/
            $registrar->resource('regions', RegionController::class);

            // Region to Cities relations
            $registrar->get('regions/{id}/relationships/cities',[
                RegionCitiesRelationshipsController::class, 'index'
            ])->name('region.relationships.cities');

            $registrar->patch('regions/{id}/relationships/cities',[
                RegionCitiesRelationshipsController::class, 'patch'
            ])->name('region.relationships.cities');

            $registrar->get('regions/{id}/cities',[
                RegionCitiesRelatedController::class, 'index'
            ])->name('region.cities');

            // Regions to Federal District relations
            $registrar->get('regions/{id}/relationships/federal-district',[
                RegionsFederalDistrictRelationshipsController::class, 'index'
            ])->name('regions.relationships.federal-district');

            $registrar->patch('regions/{id}/relationships/federal-district',[
                RegionsFederalDistrictRelationshipsController::class, 'patch'
            ])->name('regions.relationships.federal-district');

            $registrar->get('regions/{id}/federal-district',[
                RegionsFederalDistrictRelatedController::class, 'index'
            ])->name('regions.federal-district');

            /*****************  FEDERAL DISTRICT ROUTES **************/
            $registrar->resource('federal-districts', FederalDistrictController::class);

            // Federal District to Regions relations
            $registrar->get('federal-districts/{id}/relationships/regions',[
                FederalDistrictRegionsRelationshipsController::class, 'index'
            ])->name('federal-district.relationships.regions');

            $registrar->patch('federal-districts/{id}/relationships/regions',[
                FederalDistrictRegionsRelationshipsController::class, 'update'
            ])->name('federal-district.relationships.regions');

            $registrar->get('federal-districts/{id}/regions',[
                FederalDistrictRegionsRelatedController::class, 'index'
            ])->name('federal-district.regions');
        });
    }
}