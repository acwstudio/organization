<?php

declare(strict_types=1);

namespace App\Routing\Registrars;

use App\Http\Controllers\Api\Organizations\OrganizationController;
use App\Http\Controllers\Api\Organizations\OrganizationsCityRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationsCityRelationshipsController;
use App\Http\Controllers\Api\Organizations\OrganizationsOrganizationTypeRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationsOrganizationTypeRelationshipsController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypeChildrenRelatedController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypeChildrenRelationshipsController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypeController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypeOrganizationsRelatedController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypeOrganizationsRelationshipsController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypesParentRelatedController;
use App\Http\Controllers\Api\OrganizationTypes\OrganizationTypesParentRelationshipsController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

final class OrganizationRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        $registrar->group(['prefix' => 'api/v1', 'middleware' => 'api'], function (Registrar $registrar) {

            /*****************  ORGANIZATION ROUTES **************/
            $registrar->resource('organizations', OrganizationController::class);

            // Organizations to Organization Type relations
            $registrar->get('organizations/{id}/relationships/organization-type', [
                OrganizationsOrganizationTypeRelationshipsController::class, 'index'
            ])->name('organizations.relationships.organization-type');

            $registrar->patch('organizations/{id}/relationships/organization-type', [
                OrganizationsOrganizationTypeRelationshipsController::class, 'update'
            ])->name('organizations.relationships.organization-type');

            $registrar->get('organizations/{id}/organization-type', [
                OrganizationsOrganizationTypeRelatedController::class, 'index'
            ])->name('organizations.organization-type');

            // Organizations to City relationships
            $registrar->get('organizations/{id}/relationships/city',[
                OrganizationsCityRelationshipsController::class,'index'
            ])->name('organizations.relationships.city');

            $registrar->patch('organizations/{id}/relationships/city',[
                OrganizationsCityRelationshipsController::class,'update'
            ])->name('organizations.relationships.city');

            $registrar->get('organizations/{id}/city',[
                OrganizationsCityRelatedController::class,'index'
            ])->name('organizations.city');

            /*****************  ORGANIZATION TYPE ROUTES **************/
            $registrar->resource('organization-types', OrganizationTypeController::class);

            // Organization Type to Organizations relations
            $registrar->get('organization-types/{id}/relationships/organizations',[
                OrganizationTypeOrganizationsRelationshipsController::class,'index'
            ])->name('organization-type.relationships.organizations');

            $registrar->patch('organization-types/{id}/relationships/organizations',[
                OrganizationTypeOrganizationsRelationshipsController::class,'update'
            ])->name('organization-type.relationships.organizations');

            $registrar->get('organization-types/{id}/organizations',[
                OrganizationTypeOrganizationsRelatedController::class,'index'
            ])->name('organization-type.organizations');

            // Organization Type to children relations
            $registrar->get('organization-types/{id}/relationships/children',[
                OrganizationTypeChildrenRelationshipsController::class,'index'
            ])->name('organization-type.relationships.children');

            $registrar->patch('organization-types/{id}/relationships/children',[
                OrganizationTypeChildrenRelationshipsController::class,'update'
            ])->name('organization-type.relationships.children');

            $registrar->get('organization-types/{id}/children',[
                OrganizationTypeChildrenRelatedController::class,'index'
            ])->name('organization-type.children');

            // Organization Types to parent relations
            $registrar->get('organization-types/{id}/relationships/parent',[
                OrganizationTypesParentRelationshipsController::class,'index'
            ])->name('organization-types.relationships.parent');

            $registrar->patch('organization-types/{id}/relationships/parent',[
                OrganizationTypesParentRelationshipsController::class,'update'
            ])->name('organization-types.relationships.parent');

            $registrar->get('organization-types/{id}/parent',[
                OrganizationTypesParentRelatedController::class
            ])->name('organization-types.parent');
        });
    }
}
