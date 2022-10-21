<?php

declare(strict_types=1);

namespace App\Repositories\Api\Cities;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Eloquent\Model;

final class CitiesRegionRelationsRepository
{
    /**
     * @param int $id
     * @return Model|Region
     */
    public function indexRelations(int $id): Model|Region
    {
        return City::findOrFail($id)->region;
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateRelations(array $data): void
    {
        City::findOrFail(data_get($data, 'city_id'))->update([
            'region_id' => data_get($data, 'data.id')
        ]);
    }
}
