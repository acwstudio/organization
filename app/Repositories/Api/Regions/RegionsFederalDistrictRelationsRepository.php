<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Repositories\Api\AbstractRelationshipsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionsFederalDistrictRelationsRepository extends AbstractRelationshipsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelationships(int $id): HasMany
    {
        return Region::findOrFail($id)->federalDistrict;
    }

    public function updateToManyRelationships(array $data): void
    {
        // TODO: Implement updateToManyRelationships() method.
    }

    public function updateToOneRelationship(array $data): void
    {
        $federalDistrictId = data_get($data, 'data.*.id');
        $regionId = data_get($data,'region_id');

        if ($federalDistrictId){
            Region::findOrFail($regionId)->update([
                'federal_district_id' => $federalDistrictId
            ]);
        } else {
            Region::findOrFail($regionId)->update([
                'federal_district_id' => null
            ]);
        }
    }

    public function updateManyToManyRelationships(): void
    {
        // TODO: Implement updateManyToManyRelationships() method.
    }
}
