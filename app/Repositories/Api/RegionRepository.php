<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\Region;
use Spatie\QueryBuilder\QueryBuilder;

final class RegionRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(Region::class)
            ->allowedIncludes(['cities','federalDistrict'])
            ->allowedFilters(['name','id'])
            ->allowedSorts(['name']);
    }

    /**
     * @param Region $region
     * @return QueryBuilder
     */
    public function show(Region $region): QueryBuilder
    {
        return QueryBuilder::for(Region::class)
            ->where('id', $region->id)
            ->allowedIncludes(['cities','federalDistrict']);
    }
}
