<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionRelationshipsRepository extends AbstractRelationshipsRepository
{

    /**
     * @param array $data
     * @return HasMany|BelongsTo
     */
    public function indexRelations(array $data): HasMany|BelongsTo
    {
        $relation = data_get($data, 'relation_method');
        $id = data_get($data, 'id');

        return Region::findOrFail($id)->{$relation}();
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

        data_get($data, 'model') ?? data_set($data, 'model', Region::findOrFail(data_get($data, 'id')));
        $this->handleUpdateRelations($data);
    }
}
