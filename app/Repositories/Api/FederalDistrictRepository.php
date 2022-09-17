<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use App\Models\FederalDistrict;
use Illuminate\Database\Eloquent\Model;
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

    /**
     * @param FederalDistrict $model
     * @return QueryBuilder
     */
    public function show(FederalDistrict $federalDistrict): QueryBuilder
    {
        return QueryBuilder::for(FederalDistrict::class)
            ->where('id', $federalDistrict->id)
            ->allowedIncludes(['regions']);
    }
}
