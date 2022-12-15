<?php

namespace App\Http\Resources\Api\FederalDistricts;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\FederalDistrict;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FederalDistrictCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * @return int
     */
    protected function total(): int
    {
        return FederalDistrict::where('active', true)->count();
    }
}
