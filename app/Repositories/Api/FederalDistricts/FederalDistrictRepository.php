<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
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
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug')
            ])
            ->allowedSorts(['name','id']);
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
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        return QueryBuilder::for(FederalDistrict::class)
            ->where('id', $id)
            ->allowedIncludes(['regions']);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return void
     */
    public function update(array $attributes, int $id): void
    {
        FederalDistrict::findOrFail($id)->update($attributes);
    }

    /**
     * @param array $data
     * @return void
     */
    public function destroy(array $data): void
    {
        $model = data_get($data, 'model');

        $model->delete();
    }
}
