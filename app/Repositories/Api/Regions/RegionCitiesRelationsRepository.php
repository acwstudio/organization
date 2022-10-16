<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\City;
use App\Models\Region;

final class RegionCitiesRelationsRepository
{
    public function indexRelations(int $id)
    {
        return Region::findOrFail($id)->cities();
    }

    /**
     * @param array $ids
     * @param string $relatedModel
     * @param Region $model
     * @return void
     */
    public  function updateRelations(array $ids, int $id): void
    {
        $relModels = [];

        foreach ($ids as $itemId) {
            $relModels[] = City::findOrFail($itemId);
        }

        Region::findOrFail($id)->cities()->saveMany($relModels);
    }

    public function destroyRelatedModels(int $id)
    {
        foreach (Region::findOrFail($id)->cities as $item) {
            $item->delete();
        }
    }
}
