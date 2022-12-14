<?php

declare(strict_types=1);

namespace App\Repositories\Api\Organizations;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

final class OrganizationRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(Organization::class)
            ->allowedFields(['parent_id','city_id','organization_type_id','id','name'])
            ->allowedIncludes(['organizationType','city','faculties','parent','children'])
            ->allowedFilters(['name','id'])
            ->allowedSorts(['name']);
    }

    /**
     * @param array $data
     * @return Model|Organization
     */
    public function store(array $data): Model|Organization
    {
        return Organization::create(data_get($data, 'data.attributes'));
    }

    /**
     * @param Organization $organization
     * @return QueryBuilder
     */
    public function show(Organization $organization): QueryBuilder
    {
        return QueryBuilder::for(Organization::class)
            ->where('id', $organization->id)
            ->allowedIncludes(['organizationType','city','faculties','parent','children']);
    }
}
