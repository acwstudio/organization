<?php

namespace App\Http\Resources\Api\Cities;

use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Http\Resources\Api\Regions\RegionResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin City */
class CityResource extends JsonResource
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
            'type' => City::TYPE_RESOURCE,
            'attributes' => $this->attributeItems(),
            'relationships' => [
                'region' => $this->sectionRelationships('cities.region', RegionResource::class),
                'organizations' => $this->sectionRelationships('city.organizations', OrganizationCollection::class)
            ]
        ];
    }

    protected function relations(): array
    {
        return [
            RegionResource::class => $this->whenLoaded('region'),
            OrganizationCollection::class => $this->whenLoaded('organizations')
        ];
    }
}
