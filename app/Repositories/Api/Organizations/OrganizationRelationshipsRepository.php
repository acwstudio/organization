<?php

declare(strict_types=1);

namespace App\Repositories\Api\Organizations;

use App\Models\Organization;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class OrganizationRelationshipsRepository extends AbstractRelationshipsRepository
{

    public function indexRelations(array $data): HasMany|BelongsTo|HasOne
    {
        $relation = data_get($data, 'relation_method');
        $id = data_get($data, 'id');

        return Organization::findOrFail($id)->{$relation}();
    }

    public function updateRelations(array $data): void
    {
        // TODO: Implement updateRelations() method.
    }
}
