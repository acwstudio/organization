<?php

declare(strict_types=1);

namespace App\Repositories\Api\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;

final class FederalDistrictRegionsRelationsRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function indexRelations(int $id): mixed
    {
        return FederalDistrict::findOrFail($id)->regions();
    }

    /**
     * @param array $data
     * @return void
     */
    public  function updateRelations(array $data): void
    {
        $regions = [];

        foreach (data_get($data, 'data.*.id') as $regionId) {
            $regions[] = Region::findOrFail($regionId);
        }

        FederalDistrict::findOrFail(data_get($data,'federal_district_id'))->regions()->saveMany($regions);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroyRelations(int $id): void
    {
        foreach (FederalDistrict::findOrFail($id)->regions as $item) {
            $item->update([
                'federal_district_id' => null
            ]);
        }
    }
}
