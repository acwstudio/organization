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
}
