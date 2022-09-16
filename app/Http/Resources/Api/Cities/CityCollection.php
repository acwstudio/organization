<?php

namespace App\Http\Resources\Api\Cities;

use App\Http\Resources\Concerns\IncludeRelatedEntitiesCollectionTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
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
        ];
    }
}