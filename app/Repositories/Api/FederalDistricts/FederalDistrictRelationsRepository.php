<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Repositories\Api\AbstractRelationsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class FederalDistrictRelationsRepository extends AbstractRelationsRepository
{
    public function indexRelations(array $data): Model|Collection
    {
        $relation = data_get($data, 'relation');
        $id = data_get($data, 'id');

        return FederalDistrict::findOrFail($id)->{$relation};
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function storeRelations(array $data): void
    {
        // HasOne, HasMany, morphOne, morphMany
        // belongsTo, morphTo
        // belongsToMany, morphedToMany, morphedByMany

        $this->handleStoreRelations($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        // HasOne, HasMany, morphOne, morphMany
        // belongsTo, morphTo
        // belongsToMany, morphedToMany, morphedByMany

        $this->handleUpdateRelations($data);

    }
}
