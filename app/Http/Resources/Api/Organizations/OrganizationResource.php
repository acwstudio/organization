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
                    'links' => $this->sectionLinks([
                        'href' => route('organizations.city', ['id' => $this->id]),
                        'self' => route('organizations.relationships.city', ['id' => $this->id]),
                        'resourceName' => CityResource::class
                    ]),

                    'data' => $this->relatedIdentifiers(CityResource::class)
                ],
                'organizationType' => [
                    'links' => $this->sectionLinks([
                        'href' => route('organizations.organization-type', ['id' => $this->id]),
                        'self' => route('organizations.relationships.organization-type', ['id' => $this->id]),
                        'resourceName' => OrganizationTypeResource::class
                    ]),

                    'data' => $this->relatedIdentifiers(OrganizationTypeResource::class)
                ],
                'faculties' => [
                    'links' => $this->sectionLinks([
                        'href' => route('organization.faculties', ['id' => $this->id]),
                        'self' => route('organization.relationships.faculties', ['id' => $this->id]),
                        'resourceName' => FacultyCollection::class
                    ]),

                    'data' => $this->relatedIdentifiers(FacultyCollection::class)
                ],
                'parent' => [
                    'links' => $this->sectionLinks([
                        'href' => route('organizations.parent', ['id' => $this->id]),
                        'self' => route('organizations.relationships.parent', ['id' => $this->id]),
                        'resourceName' => OrganizationResource::class
                    ]),

                    'data' => $this->relatedIdentifiers(OrganizationResource::class)
                ],
                'children' => [
                    'links' => $this->sectionLinks([
                        'href' => route('organization.children', ['id' => $this->id]),
                        'self' => route('organization.relationships.children', ['id' => $this->id]),
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
            CityResource::class             => $this->whenLoaded('city'),
            OrganizationTypeResource::class => $this->whenLoaded('organizationType'),
            FacultyCollection::class        => $this->whenLoaded('faculties'),
            OrganizationResource::class     => $this->whenLoaded('parent'),
            OrganizationCollection::class   => $this->whenLoaded('children'),
        ];
    }
}
