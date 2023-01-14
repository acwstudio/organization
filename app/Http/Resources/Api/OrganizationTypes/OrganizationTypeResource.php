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
                'parent' => $this->sectionRelationships('organization-types.parent', OrganizationTypeResource::class),
                'children' => $this->sectionRelationships('organization-type.children', OrganizationTypeCollection::class),
                'organizations' => $this->sectionRelationships('organization-type.organizations', OrganizationCollection::class),
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
