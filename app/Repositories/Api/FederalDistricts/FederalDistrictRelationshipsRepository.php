<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class FederalDistrictRelationshipsRepository extends AbstractRelationshipsRepository
{
    public function indexRelations(array $data): HasMany
    {
        $relation = data_get($data, 'relation_method');
        $id = data_get($data, 'id');

        return FederalDistrict::findOrFail($id)->{$relation}();
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function updateRelations(array $data): void
    {
        /**
         * HasOne, HasMany, MorphOne, MorphMany
         * BelongsTo, MorphTo
         * BelongsToMany, MorphedToMany, MorphedByMany
         */

        data_get($data, 'model') ?? data_set($data, 'model', FederalDistrict::findOrFail(data_get($data, 'id')));
        $this->handleUpdateRelations($data);
    }
}
