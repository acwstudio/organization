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
     * @param array $ids
     * @param int $id
     * @return void
     */
    public  function updateRelations(array $ids, int $id): void
    {
        $relModels = [];

        foreach ($ids as $itemId) {
            $relModels[] = Region::findOrFail($itemId);
        }

        FederalDistrict::findOrFail($id)->regions()->saveMany($relModels);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroyRelations(int $id): void
    {
        FederalDistrict::findOrFail($id)->regions()->delete();
    }
}
