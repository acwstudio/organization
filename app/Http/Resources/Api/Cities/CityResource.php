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
                'region' => [
                    'links' => $this->sectionLinks([
                        'self' => route('cities.relationships.region', ['id' => $this->id]),
                        'href' => route('cities.region', ['id' => $this->id]),
                        'resourceName' => RegionResource::class
                    ]),

                    'data' => $this->relatedIdentifiers(RegionResource::class)
                ],
                'organizations' => [
                    'links' => $this->sectionLinks([
                        'self' => route('city.relationships.organizations', ['id' => $this->id]),
                        'href' => route('city.organizations', ['id' => $this->id]),
                        'resourceName' => OrganizationCollection::class
                    ]),

                    'data' => $this->relatedIdentifiers(OrganizationCollection::class)
                ]
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
