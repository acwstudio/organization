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
                'city' => $this->sectionRelationships('organizations.city', CityResource::class),
                'organizationType' => $this->sectionRelationships('organizations.organization-type', OrganizationTypeResource::class),
                'faculties' => $this->sectionRelationships('organization.faculties', FacultyCollection::class),
                'parent' => $this->sectionRelationships('organizations.parent', OrganizationResource::class),
                'children' => $this->sectionRelationships('organization.children', OrganizationCollection::class)
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
