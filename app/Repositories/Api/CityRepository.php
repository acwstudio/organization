<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\City;
use Spatie\QueryBuilder\QueryBuilder;

final class CityRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(City::class)
            ->allowedIncludes(['organizations','region'])
            ->allowedFilters(['name','id'])
            ->allowedSorts(['name']);
    }
}
