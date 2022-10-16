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
     * @param int $relatedId
     * @param int $id
     * @return void
     */
    public function updateRelations(int $relatedId, int $id): void
    {
        Region::findOrFail($id)->update([
            'federal_district_id' => $relatedId
        ]);
    }

    public function destroyRelations(int $id)
    {

    }
}
