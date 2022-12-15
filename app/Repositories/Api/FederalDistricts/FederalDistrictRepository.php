<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Repositories\Api\AbstractCRUDRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class FederalDistrictRepository extends AbstractCRUDRepository
{
    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return QueryBuilder::for(FederalDistrict::class)
            ->allowedFields(['id','name'])
            ->allowedIncludes(['regions'])
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('slug')
            ])
            ->allowedSorts(['name','id']);
    }

    /**
     * @param array $data
     * @return Model|FederalDistrict
     */
    public function store(array $data): Model|FederalDistrict
    {
        return FederalDistrict::create(data_get($data, 'data.attributes'));
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        // it is just only for ModelNotFoundException
        $federalDistrict = FederalDistrict::findOrFail($id);

        return QueryBuilder::for(FederalDistrict::class)
            ->where('id', $federalDistrict->id)
            ->allowedIncludes(['regions']);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function update(array $data): Model|FederalDistrict
    {
        $model = FederalDistrict::findOrFail(data_get($data, 'id'));

        $model->update(data_get($data, 'data.attributes'));

        return $model;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        FederalDistrict::findOrFail($id)->delete();
    }
}
