<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\FederalDistrict;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(FederalDistrict::class)
            ->allowedIncludes(['regions'])
            ->allowedFilters(['name','id'])
            ->allowedSorts(['name']);
    }
}
