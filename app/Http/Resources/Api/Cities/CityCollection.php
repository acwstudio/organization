<?php

namespace App\Http\Resources\Api\Cities;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\City;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * @return int
     */
    protected function total(): int
    {
        return City::where('active', true)->count();
    }
}
