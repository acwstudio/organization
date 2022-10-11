<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
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
            ->allowedFilters(['name','id','federal_district_id'])
            ->allowedSorts(['name','federal_district_id']);
    }

    /**
     * @param array $attributes
     * @return Model|Region
     */
    public function store(array $attributes): Model | Region
    {
        return Region::create($attributes);
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

    /**
     * @param array $attributes
     * @param Region $model
     * @return void
     */
    public function update(array $attributes, Region $model): void
    {
        $model->update($attributes);
    }

    /**
     * @param Region $model
     * @return void
     */
    public function destroy(Region $model): void
    {
        $model->delete();
    }
}
