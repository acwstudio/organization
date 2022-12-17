<?php

namespace App\Http\Resources\Api\Organizations;

use App\Http\Resources\Api\Cities\CityResource;
use App\Http\Resources\Api\Faculties\FacultyCollection;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Organization */
class OrganizationResource extends JsonResource
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
            'type' => Organization::TYPE_RESOURCE,
            'attributes' => $this->attributeItems(),
            'relationships' => [
                'city' => [
                    'links' => [
                        'self' => route('organizations.relationships.city', ['id' => $this->id]),
                        'related' => [
                            'href' => route('organizations.city', ['id' => $this->id])
                        ],
                    ],
                    'data' => $this->relatedIdentifiers(CityResource::class)
                ],
                'organizationType' => [
                    'links' => [
                        'self' => route('organizations.relationships.organization-type', ['id' => $this->id]),
                        'related' => [
                            'href' => route('organizations.organization-type', ['id' => $this->id])
                        ]
                    ],
                    'data' => $this->relatedIdentifiers(OrganizationTypeResource::class)
                ],
                'faculties' => [
                    'links' => [
                        'self' => route('organization.relationships.faculties', ['id' => $this->id]),
                        'related' => [
                            'href' => route('organization.faculties', ['id' => $this->id]),
                            'meta' => [
                                'total' => $this->totalRelatedData($this->relations()[FacultyCollection::class]),
                                'limit' => $this->limitRelatedItems()
                            ]
                        ],
                    ],
                    'data' => $this->relatedIdentifiers(FacultyCollection::class)
                ],
                'parent' => [
                    'links' => [
                        'self' => route('organizations.relationships.parent', ['id' => $this->id]),
                        'related' => [
                            'href' => route('organizations.parent', ['id' => $this->id])
                        ]
                    ],
                    'data' => $this->relatedIdentifiers(OrganizationResource::class)
                ],
                'children' => [
                    'links' => [
                        'self' => route('organization.relationships.children', ['id' => $this->id]),
                        'related' => [
                            'href' => route('organization.children', ['id' => $this->id]),
                            'meta' => [
                                'total' => $this->totalRelatedData($this->relations()[OrganizationCollection::class]),
                                'limit' => $this->limitRelatedItems()
                            ]
                        ]
                    ],
                    'data' => $this->relatedIdentifiers(OrganizationCollection::class)
                ]
            ]
        ];
    }

    protected function relations(): array
    {
        return [
            CityResource::class             => $this->whenLoaded('city'),
            OrganizationTypeResource::class => $this->whenLoaded('organizationType'),
            FacultyCollection::class        => $this->whenLoaded('faculties'),
            OrganizationResource::class     => $this->whenLoaded('parent'),
            OrganizationCollection::class   => $this->whenLoaded('children'),
        ];
    }
}
