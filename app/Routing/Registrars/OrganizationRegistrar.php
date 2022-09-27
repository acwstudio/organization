<?php

declare(strict_types=1);

namespace App\Routing\Registrars;

use App\Http\Controllers\Api\Faculties\FacultiesOrganizationRelatedController;
use App\Http\Controllers\Api\Faculties\FacultiesOrganizationRelationshipsController;
use App\Http\Controllers\Api\Faculties\FacultyController;
use App\Http\Controllers\Api\Organizations\OrganizationChildrenRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationChildrenRelationshipsController;
use App\Http\Controllers\Api\Organizations\OrganizationController;
use App\Http\Controllers\Api\Organizations\OrganizationFacultiesRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationFacultiesRelationshipsController;
use App\Http\Controllers\Api\Organizations\OrganizationsCityRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationsCityRelationshipsController;
use App\Http\Controllers\Api\Organizations\OrganizationsOrganizationTypeRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationsOrganizationTypeRelationshipsController;
use App\Http\Controllers\Api\Organizations\OrganizationsParentRelatedController;
use App\Http\Controllers\Api\Organizations\OrganizationsParentRelationshipsController;
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

            /*****************  FACULTY ROUTES **************/
            $registrar->resource('faculties', FacultyController::class);

            // Faculties to Organization relationships
            $registrar->get('faculties/{id}/relationships/organization',[
                FacultiesOrganizationRelationshipsController::class,'index'
            ])->name('faculties.relationships.organization');

            $registrar->patch('faculties/{id}/relationships/organization',[
                FacultiesOrganizationRelationshipsController::class,'update'
            ])->name('faculties.relationships.organization');

            $registrar->get('faculties/{id}/organization',[
                FacultiesOrganizationRelatedController::class,'index'
            ])->name('faculties.organization');

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

            // Organizations to faculties relationships
            $registrar->get('organizations/{id}/relationships/faculties',[
                OrganizationFacultiesRelationshipsController::class,'index'
            ])->name('organizations.relationships.faculties');

            $registrar->patch('organizations/{id}/relationships/faculties',[
                OrganizationFacultiesRelationshipsController::class,'update'
            ])->name('organizations.relationships.faculties');

            $registrar->get('organizations/{id}/faculties',[
                OrganizationFacultiesRelatedController::class,'index'
            ])->name('organizations.faculties');

            // Organization to children relations
            $registrar->get('organizations/{id}/relationships/children', [
                OrganizationChildrenRelationshipsController::class,'index'
            ])->name('organization.relationships.children');

            $registrar->patch('organizations/{id}/relationships/children', [
                OrganizationChildrenRelationshipsController::class,'update'
            ])->name('organization.relationships.children');

            $registrar->get('organizations/{id}/children', [
                OrganizationChildrenRelatedController::class,'index'
            ])->name('organization.children');

            // Organizations to parent relations
            $registrar->get('organizations/{id}/relationships/parent', [
                OrganizationsParentRelationshipsController::class,'index'
            ])->name('organizations.relationships.parent');

            $registrar->patch('organizations/{id}/relationships/parent', [
                OrganizationsParentRelationshipsController::class,'update'
            ])->name('organizations.relationships.parent');

            $registrar->get('organizations/{id}/parent', [
                OrganizationsParentRelatedController::class,'index'
            ])->name('organizations.parent');

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
                OrganizationTypesParentRelatedController::class, 'index'
            ])->name('organization-types.parent');
        });
    }
}
