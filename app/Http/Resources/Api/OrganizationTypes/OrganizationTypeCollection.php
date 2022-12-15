<?php

namespace App\Http\Resources\Api\OrganizationTypes;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\OrganizationType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationTypeCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * @return int
     */
    protected function total(): int
    {
        return OrganizationType::where('active', true)->count();
    }
}
