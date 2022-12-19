<?php

namespace App\Http\Resources\Api\FederalDistricts;

use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\FederalDistrict;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FederalDistrict */
class FederalDistrictResource extends JsonResource
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
            'type'       => FederalDistrict::TYPE_RESOURCE,
            'attributes' => $this->attributeItems(),
            'relationships' => [
                'regions' => [
                    'links' => $this->sectionLinks([
                        'self'    => route('federal-district.relationships.regions', ['id' => $this->id]),
                        'href' => route('federal-district.regions', ['id' => $this->id]),
                        'resourceName' => RegionCollection::class
                    ]),
                    'data' => $this->relatedIdentifiers(RegionCollection::class)
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    protected function relations(): array
    {
        return [
            RegionCollection::class => $this->whenLoaded('regions')
        ];
    }
}
