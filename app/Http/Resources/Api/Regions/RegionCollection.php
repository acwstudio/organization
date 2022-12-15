<?php

namespace App\Http\Resources\Api\Regions;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use App\Models\Region;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RegionCollection extends ResourceCollection
{
    use IncludeRelatedEntitiesCollectionTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data'     => $this->collection,
            'included' => $this->mergeIncludedRelations($request),
            'meta' => [
                'total' => $this->total()
            ]
        ];
    }

    protected function total(): int
    {
        return Region::count();
    }
}
