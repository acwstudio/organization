<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class RegionCitiesRelationsRepository
{
    /**
     * @param int $id
     * @return HasMany
     */
    public function indexRelations(int $id): HasMany
    {
        return Region::findOrFail($id)->cities();
    }

    /**
     * @param array $data
     * @return void
     */
    public  function updateRelations(array $data): void
    {
        $cities = [];

        foreach (data_get($data,'data.relationships.cities.data.*.id') as $cityId) {
            $cities[] = City::findOrFail($cityId);
        }

        Region::findOrFail(data_get($data,'id'))->cities()->saveMany($cities);
    }

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
}
