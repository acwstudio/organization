<?php

namespace App\Http\Resources\Api\Regions;

use App\Http\Resources\Api\Cities\CityCollection;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\Region;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
class RegionResource extends JsonResource
{
    use IncludeRelatedEntitiesResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'type'       => Region::TYPE_RESOURCE,
            'attributes' => $this->attributeItems(),
            'relationships' => [
                'cities' => [
                    'links' => [
                        'self'    => route('region.relationships.cities', ['id' => $this->id]),
                        'related' => [
                            'href' => route('region.cities', ['id' => $this->id]),
                            'meta' => [
                                'total' => $this->totalRelatedData($this->relations()[CityCollection::class]),
                                'limit' => $this->limitRelatedItems()
                            ]
                        ],
                    ],
                    'data' => $this->relatedIdentifiers(CityCollection::class)
                ],
                'federalDistrict' => [
                    'links' => [
                        'self'    => route('regions.relationships.federal-district', ['id' => $this->id]),
                        'related' => [
                            'href' => route('regions.federal-district', ['id' => $this->id])
                        ],
                    ],
                    'data' => $this->relatedIdentifiers(FederalDistrictResource::class)
                ]
            ]
        ];
    }

    protected function relations(): array
    {
        return [
            CityCollection::class          => $this->whenLoaded('cities'),
            FederalDistrictResource::class => $this->whenLoaded('federalDistrict')
        ];
    }
}
