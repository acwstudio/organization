<?php

namespace App\Http\Resources\Api\OrganizationTypes;

use App\Http\Resources\Api\Organizations\OrganizationCollection;
use App\Http\Resources\Api\Organizations\OrganizationIdentifierResource;
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
            'attributes' => [
                'parent_id'   => $this->parent_id,
                'name'        => $this->name,
                'description' => $this->description,
                'slug'        => $this->slug,
                'active'      => $this->active,
                'created_at'  => $this->created_at,
                'updated_at'  => $this->updated_at,
            ],
            'relationships' => [
                'parent' => [
                    'links' => [
                        'self'    => route('organization-types.relationships.parent',[$this->id]),
                        'related' => route('organization-types.parent',[$this->id]),
                    ],
                    'data' => new OrganizationTypeIdentifierResource(
                        $this->relatedData($this->relations()[OrganizationTypeResource::class])
                    )
                ],
                'children' => [
                    'links' => [
                        'self' => route('organization-type.relationships.children',[$this->id]),
                        'related' => route('organization-type.children',[$this->id]),
                    ],
                    'data' => OrganizationTypeIdentifierResource::collection(
                        $this->relatedData($this->relations()[OrganizationTypeCollection::class])
                    )
                ],
                'organizations' => [
                    'links' => [
                        'self' => route('organization-type.relationships.organizations',[$this->id]),
                        'related' => route('organization-type.organizations',[$this->id]),
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
            OrganizationCollection::class     => $this->whenLoaded('organizations'),
            OrganizationTypeResource::class   => $this->whenLoaded('parent'),
            OrganizationTypeCollection::class => $this->whenLoaded('children'),
        ];
    }
}
