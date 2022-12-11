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
            'attributes' => [
                'region_id' => $this->region_id,
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
                'active' => $this->active,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'region' => [
                    'links' => [
                        'self' => route('cities.relationships.region', ['id' => $this->id]),
                        'related' => route('cities.region', ['id' => $this->id]),
                    ],
                    'data' => new RegionIdentifierResource(
                        $this->relatedData($this->relations()[RegionResource::class])
                    )
                ],
                'organizations' => [
                    'links' => [
                        'self' => route('city.relationships.organizations', ['id' => $this->id]),
                        'related' => route('city.organizations', ['id' => $this->id]),
                    ],
                    'data' => OrganizationIdentifierResource::collection(
                        $this->relatedData($this->relations()[OrganizationCollection::class])
                    ),
                    'meta' => [
                        'total' => $this->totalRelatedData($this->relations()[OrganizationCollection::class]),
                        'limit' => config('api-settings.limit-included')
                    ]
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
