<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\Region;
use App\Repositories\Api\AbstractCRUDRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class RegionRepository extends AbstractCRUDRepository
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
            ->allowedSorts(['name','federal_district_id','id']);
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
    public function update(array $data): Model
    {
        $model = Region::findOrFail(data_get($data, 'id'));

        $model->update(data_get($data, 'data.attributes'));

        return $model;
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
