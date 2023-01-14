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
                'cities' => $this->sectionRelationships('region.cities', CityCollection::class),
                'federalDistrict' => $this->sectionRelationships('regions.federal-district', FederalDistrictResource::class),
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
