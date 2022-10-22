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
        // it is just only for ModelNotFoundException
        $federalDistrict = FederalDistrict::findOrFail($id);

        return QueryBuilder::for(FederalDistrict::class)
            ->where('id', $federalDistrict->id)
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
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        FederalDistrict::findOrFail($id)->delete();
    }
}
