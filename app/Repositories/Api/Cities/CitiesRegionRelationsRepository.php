<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;
use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class CitiesRegionRelationsRepository extends AbstractRelationshipsRepository
{
    public function indexToManyRelationships(int $id): HasMany
    {
        // TODO: Implement indexToManyRelationships() method.
    }

    public function indexToOneRelationships(int $id): Model
    {
        return City::findOrFail($id)->region;
    }

    public function updateToManyRelationships(array $data): void
    {
        // TODO: Implement updateToManyRelationships() method.
    }

    public function updateToOneRelationship(array $data): void
    {
        $regionId = data_get($data, 'data.id');
        $cityId = data_get($data,'city_id');

        if ($regionId){
            City::findOrFail($cityId)->update([
                'region_id' => $regionId
            ]);
        } else {
            City::findOrFail($cityId)->update([
                'region_id' => null
            ]);
        }
    }

    public function updateManyToManyRelationships(): void
    {
        // TODO: Implement updateManyToManyRelationships() method.
    }
}
