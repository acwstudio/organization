<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class FederalDistrictRegionsRelationsRepository extends AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return HasMany
     */
    public function indexRelationships(int $id): HasMany
    {
        return FederalDistrict::findOrFail($id)->regions();
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateToManyRelationships(array $data): void
    {
        $regionIds = data_get($data, 'data.*.id');
        $federalDistrictId = data_get($data,'federal_district_id');

        if ($regionIds) {
            foreach ($regionIds as $regionId) {
                Region::findOrFail($regionId)->update(['federal_district_id' => $federalDistrictId]);
            }
        } else {
            foreach (FederalDistrict::findOrFail($federalDistrictId)->regions as $region) {
                $region->update(['federal_district_id' => null]);
            }
        }
    }

    public function updateToOneRelationship(): void
    {
        // TODO: Implement updateToOneRelationship() method.
    }

    public function updateManyToManyRelationships(): void
    {
        // TODO: Implement updateNanyToManyRelationship() method.
    }
}
