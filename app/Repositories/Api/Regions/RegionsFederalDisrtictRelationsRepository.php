<?php

declare(strict_types=1);

namespace App\Repositories\Api\Regions;

use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Database\Eloquent\Model;

final class RegionsFederalDisrtictRelationsRepository
{
    /**
     * @param int $id
     * @return Model|FederalDistrict
     */
    public function indexRelations(int $id): Model | FederalDistrict
    {
        return Region::findOrFail($id)->federalDistrict;
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateRelations(array $data): void
    {
        Region::findOrFail(data_get($data, 'region_id'))->update([
            'federal_district_id' => data_get($data, 'data.id')
        ]);
    }

    public function destroyRelations(int $id)
    {

    }
}
