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
     * @param array $attributes
     * @return Model|FederalDistrict
     */
    public function store(array $attributes): Model|FederalDistrict
    {
        return FederalDistrict::create($attributes);
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
