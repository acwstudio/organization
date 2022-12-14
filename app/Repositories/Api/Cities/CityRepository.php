<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;
use App\Repositories\Api\AbstractCRUDRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class CityRepository extends AbstractCRUDRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(City::class)
            ->allowedFields(['id','region_id','name'])
            ->allowedIncludes(['organizations','region'])
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('region_id'),
            ])
            ->allowedSorts(['name','id']);
    }

    /**
     * @param array $data
     * @return Model|City
     */
    public function store(array $data): Model|City
    {
        return City::create(data_get($data, 'data.attributes'));
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        // it is just only for ModelNotFoundException
        $city = City::findOrFail($id);

        return QueryBuilder::for(City::class)
            ->where('id', $city->id)
            ->allowedIncludes(['organizations','region']);
    }

    /**
     * @param array $data
     * @return Model|City
     */
    public function update(array $data): Model|City
    {
        $model = City::findOrFail(data_get($data, 'id'));

        $model->update(data_get($data, 'data.attributes'));

        return $model;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        City::findOrFail($id)->delete();
    }
}
