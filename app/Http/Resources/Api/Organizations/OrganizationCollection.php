<?php

namespace App\Http\Resources\Api\Organizations;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * @return int
     */
    private function total(): int
    {
        return Organization::count();
    }
}
