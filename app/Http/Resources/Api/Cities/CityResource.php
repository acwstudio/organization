<?php

namespace App\Http\Resources\Api\Cities;

use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
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
                    'links' => [
                        'self' => route('cities.relationships.region', ['id' => $this->id]),
                        'related' => [
                            'href' => route('cities.region', ['id' => $this->id]),
                        ]
                    ],
//                    'data' => new RegionIdentifierResource($this->relations()[RegionResource::class])
                    'data' => $this->relatedIdentifiers(RegionResource::class)
                ],
                'organizations' => [
                    'links' => [
                        'self' => route('city.relationships.organizations', ['id' => $this->id]),
                        'related' => [
                            'href' => route('city.organizations', ['id' => $this->id]),
                            'meta' => [
                                'total' => $this->totalRelatedData($this->relations()[OrganizationCollection::class]),
                                'limit' => $this->limitRelatedItems()
                            ]
                        ],
                    ],
//                    'data' => OrganizationIdentifierResource::collection($this->relations()[OrganizationCollection::class]),
                    'data' => $this->relatedIdentifiers(OrganizationCollection::class),
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
