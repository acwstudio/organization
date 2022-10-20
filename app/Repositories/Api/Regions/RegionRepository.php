<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
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
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('federal_district_id'),
                AllowedFilter::exact('id')
            ])
            ->allowedSorts(['name','federal_district_id']);
    }

    /**
     * @param array $attributes
     * @return Model|Region
     */
    public function store(array $attributes): Model|Region
    {
        return Region::create($attributes);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        // it is just only for ModelNotFoundException
        $region = Region::findOrFail($id);

        return QueryBuilder::for(Region::class)
            ->where('id', $region->id)
            ->allowedIncludes(['cities','federalDistrict']);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return void
     */
    public function update(array $attributes, int $id): void
    {
        Region::findOrFail($id)->update($attributes);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        Region::findOrFail($id)->delete();
    }
}
