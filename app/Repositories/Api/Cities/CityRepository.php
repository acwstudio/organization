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
            ->allowedIncludes(['organizations','region'])
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('region_id'),
            ])
            ->allowedSorts(['name']);
    }

    /**
     * @param array $attributes
     * @return Model|City
     */
    public function store(array $attributes): Model|City
    {
        return City::create($attributes);
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        return QueryBuilder::for(City::class)
            ->where('id', $id)
            ->allowedIncludes(['organizations','region']);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return void
     */
    public function update(array $attributes, int $id): void
    {
        City::findOrFail($id)->update($attributes);
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
