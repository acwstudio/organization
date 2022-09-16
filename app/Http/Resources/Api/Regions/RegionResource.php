<?php

namespace App\Http\Resources\Api\Regions;

use App\Http\Resources\Api\Cities\CityCollection;
use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Http\Resources\Api\FederalDistricts\FederalDistrictIdentifierResource;
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
            'id' => $this->id,
            'type' => Region::TYPE_RESOURCE,
            'attributes' => [
                'federal_district_id' => $this->federal_district_id,
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
                'active' => $this->active,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'cities' => [
                    'links' => [
                        'self' => route('region.relationships.cities', ['id' => $this->id]),
                        'related' => route('region.cities', ['id' => $this->id]),
                    ],
                    'data' => CityIdentifierResource::collection($this->whenLoaded('cities'))
                ],
                'federalDistrict' => [
                    'links' => [
                        'self' => route('regions.relationships.federal-district', ['id' => $this->id]),
                        'related' => route('regions.federal-district', ['id' => $this->id]),
                    ],
                    'data' => new FederalDistrictIdentifierResource($this->whenLoaded('federalDistrict'))
                ]
            ]
        ];
    }

    protected function relations(): array
    {
        return [
            CityCollection::class => $this->whenLoaded('cities'),
            FederalDistrictResource::class => $this->whenLoaded('federalDistrict')
        ];
    }
}
