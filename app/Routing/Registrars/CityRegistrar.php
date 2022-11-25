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

final class CityRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        $registrar->group(['prefix' => 'api/v1', 'middleware' => 'api'], function (Registrar $registrar) {

            /*****************  CITY ROUTES **************/
            $registrar->get('cities', [CityController::class, 'index'])->name('cities.index');
            $registrar->get('cities/{id}', [CityController::class, 'show'])->name('cities.show');
            $registrar->post('cities', [CityController::class, 'store'])->name('cities.store');
            $registrar->patch('cities/{id}', [CityController::class, 'update'])->name('cities.update');
            $registrar->delete('cities/{id}', [CityController::class, 'destroy'])->name('cities.destroy');


            // City to Organizations relations
            $registrar->get('cities/{id}/relationships/organizations',[
                CityOrganizationsRelationshipsController::class, 'index'
            ])->name('city.relationships.organizations');

            $registrar->patch('cities/{id}/relationships/organizations',[
                CityOrganizationsRelationshipsController::class, 'update'
            ])->name('city.relationships.organizations.update');

            $registrar->get('cities/{id}/organizations',[
                CityOrganizationsRelatedController::class, 'index'
            ])->name('city.organizations');

            // Cities to Region relations
            $registrar->get('cities/{id}/relationships/region', [
                CitiesRegionRelationshipsController::class, 'index'
            ])->name('cities.relationships.region');

            $registrar->patch('cities/{id}/relationships/region', [
                CitiesRegionRelationshipsController::class, 'update'
            ])->name('cities.relationships.region.update');

            $registrar->get('cities/{id}/region', [
                CitiesRegionRelatedController::class, 'index'
            ])->name('cities.region');

            /*****************  REGION ROUTES **************/
            $registrar->get('regions', [RegionController::class, 'index'])->name('regions.index');
            $registrar->get('regions/{id}', [RegionController::class, 'show'])->name('regions.show');
            $registrar->post('regions', [RegionController::class, 'store'])->name('regions.store');
            $registrar->patch('regions/{id}', [RegionController::class, 'update'])->name('regions.update');
            $registrar->delete('regions/{id}', [RegionController::class, 'destroy'])->name('regions.destroy');

            // Region to Cities relations
            $registrar->get('regions/{id}/relationships/cities',[
                RegionCitiesRelationshipsController::class, 'index'
            ])->name('region.relationships.cities');

            $registrar->patch('regions/{id}/relationships/cities',[
                RegionCitiesRelationshipsController::class, 'update'
            ])->name('region.relationships.cities.update');

            $registrar->get('regions/{id}/cities',[
                RegionCitiesRelatedController::class, 'index'
            ])->name('region.cities');

            // Regions to Federal District relations
            $registrar->get('regions/{id}/relationships/federal-district',[
                RegionsFederalDistrictRelationshipsController::class, 'index'
            ])->name('regions.relationships.federal-district');

            $registrar->patch('regions/{id}/relationships/federal-district',[
                RegionsFederalDistrictRelationshipsController::class, 'update'
            ])->name('regions.relationships.federal-district.update');

            $registrar->get('regions/{id}/federal-district',[
                RegionsFederalDistrictRelatedController::class, 'index'
            ])->name('regions.federal-district');

            /*****************  FEDERAL DISTRICT ROUTES **************/
            $registrar->get('federal-districts', [FederalDistrictController::class, 'index'])
                ->name('federal-districts.index');
            $registrar->get('federal-districts/{id}', [FederalDistrictController::class, 'show'])
                ->name('federal-districts.show');
            $registrar->post('federal-districts', [FederalDistrictController::class, 'store'])
                ->name('federal-districts.store');
            $registrar->patch('federal-districts/{id}', [FederalDistrictController::class, 'update'])
                ->name('federal-districts.update');
            $registrar->delete('federal-districts/{id}', [FederalDistrictController::class, 'destroy'])
                ->name('federal-districts.destroy');

            // Federal District to Regions relations
            $registrar->get('federal-districts/{id}/relationships/regions',[
                FederalDistrictRegionsRelationshipsController::class, 'index'
            ])->name('federal-district.relationships.regions');

            $registrar->patch('federal-districts/{id}/relationships/regions',[
                FederalDistrictRegionsRelationshipsController::class, 'update'
            ])->name('federal-district.relationships.regions.update');

            $registrar->post('federal-districts/{id}/relationships/regions',[
                FederalDistrictRegionsRelationshipsController::class, 'store'
            ])->name('federal-district.relationships.regions.store');

            $registrar->get('federal-districts/{id}/regions',[
                FederalDistrictRegionsRelatedController::class, 'index'
            ])->name('federal-district.regions');
        });
    }
}
