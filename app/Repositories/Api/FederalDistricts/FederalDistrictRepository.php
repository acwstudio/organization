<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

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
            ->allowedFilters(['name','id','slug'])
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
     * @param FederalDistrict $model
     * @return QueryBuilder
     */
    public function show(FederalDistrict $federalDistrict): QueryBuilder
    {
        return QueryBuilder::for(FederalDistrict::class)
            ->where('id', $federalDistrict->id)
            ->allowedIncludes(['regions']);
    }

    /**
     * @param array $attributes
     * @param FederalDistrict $model
     * @return void
     */
    public function update(array $attributes, FederalDistrict $model): void
    {
        $model->update($attributes);
    }

    /**
     * @param FederalDistrict $model
     * @return void
     */
    public function destroy(array $data): void
    {
        $model = data_get($data, 'model');

        $model->delete();
    }
}
