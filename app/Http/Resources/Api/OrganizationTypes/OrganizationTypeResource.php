<?php

namespace App\Http\Resources\Api\OrganizationTypes;

use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\OrganizationType;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrganizationType */
class OrganizationTypeResource extends JsonResource
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
            'type'       => OrganizationType::TYPE_RESOURCE,
            'attributes' => $this->attributeItems(),
            'relationships' => [
                'parent' => [
                    'links' => $this->sectionLinks([
                        'self'    => route('organization-types.relationships.parent',[$this->id]),
                        'href' => route('organization-types.parent',[$this->id]),
                        'resourceName' => OrganizationTypeResource::class
                    ]),
                    'data' => $this->relatedIdentifiers(OrganizationTypeResource::class)
                ],
                'children' => [
                    'links' => $this->sectionLinks([
                        'self' => route('organization-type.relationships.children',[$this->id]),
                        'href' => route('organization-type.children',[$this->id]),
                        'resourceName' => OrganizationTypeCollection::class
                    ]),
                    'data' => $this->relatedIdentifiers(OrganizationTypeCollection::class)
                ],
                'organizations' => [
                    'links' => $this->sectionLinks([
                        'self' => route('organization-type.relationships.organizations',[$this->id]),
                        'href' => route('organization-type.organizations',[$this->id]),
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
            OrganizationCollection::class     => $this->whenLoaded('organizations'),
            OrganizationTypeResource::class   => $this->whenLoaded('parent'),
            OrganizationTypeCollection::class => $this->whenLoaded('children'),
        ];
    }
}
