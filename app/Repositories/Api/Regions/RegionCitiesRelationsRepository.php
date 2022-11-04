<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\City;
use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionCitiesRelationsRepository extends AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return void
     */
    public function destroyRelatedModels(int $id): void
    {
        foreach (Region::findOrFail($id)->cities as $item) {
            $item->delete();
        }
    }

    /**
     * @param int $id
     * @return HasMany
     */
    public function indexRelationships(int $id): HasMany
    {
        return Region::findOrFail($id)->cities();
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateToManyRelationships(array $data): void
    {
        $cityIds = data_get($data, 'data.*.id');
        $regionId = data_get($data,'region_id');

        if ($cityIds) {
            foreach ($cityIds as $cityId) {
                City::findOrFail($cityId)->update(['region_id' => $regionId]);
            }
        } else {
            foreach (Region::findOrFail($regionId)->cities as $city) {
                $city->update(['region_id' => null]);
            }
        }
    }

    public function updateToOneRelationship(array $data): void
    {
        // TODO: Implement updateToOneRelationship() method.
    }

    public function updateManyToManyRelationships(): void
    {
        // TODO: Implement updateManyToManyRelationships() method.
    }
}
