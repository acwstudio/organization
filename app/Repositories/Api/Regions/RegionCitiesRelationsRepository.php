<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\City;
use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionCitiesRelationsRepository extends AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return FederalDistrict|Model
     */
    public function indexToOneRelationships(int $id): FederalDistrict|Model
    {
        return Region::findOrFail($id)->federalDistrict;
    }

    /**
     * @param int $id
     * @return HasMany
     */
    public function indexToManyRelationships(int $id): HasMany
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
