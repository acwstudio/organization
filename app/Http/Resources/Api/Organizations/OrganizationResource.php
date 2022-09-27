<?php

namespace App\Http\Resources\Api\Organizations;

use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Http\Resources\Api\Cities\CityResource;
use App\Http\Resources\Api\Faculties\FacultyCollection;
use App\Http\Resources\Api\Faculties\FacultyIdentifierResource;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
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
            'attributes' => [
                'parent_id'            => $this->parent_id,
                'city_id'              => $this->city_id,
                'organization_type_id' => $this->organization_type_id,
                'name'                 => $this->name,
                'description'          => $this->description,
                'site'                 => $this->site,
                'email'                => $this->email,
                'phone'                => $this->phone,
                'address'              => $this->address,
                'slug'                 => $this->slug,
                'plaque_image'         => $this->plaque_image,
                'preview_image'        => $this->plaque_image,
                'base_image'           => $this->plaque_image,
                'created_at'           => $this->created_at,
                'updated_at'           => $this->updated_at,
            ],
            'relationships' => [
                'city' => [
                    'links' => [
                        'self' => route('organizations.relationships.city', ['id' => $this->id]),
                        'related' => route('organizations.city', ['id' => $this->id])
                    ],
                    'data' => new CityIdentifierResource($this->whenLoaded('city'))
                ],
                'organizationType' => [
                    'links' => [
                        'self' => route('organizations.relationships.organization-type', ['id' => $this->id]),
                        'related' => route('organizations.organization-type', ['id' => $this->id])
                    ],
                    'data' => new OrganizationTypeIdentifierResource($this->whenLoaded('organizationType'))
                ],
                'faculties' => [
                    'links' => [
                        'self' => route('organizations.relationships.faculties', ['id' => $this->id]),
                        'related' => route('organizations.faculties', ['id' => $this->id])
                    ],
                    'data' => FacultyIdentifierResource::collection($this->whenLoaded('faculties'))
                ],
                'parent' => [
                    'links' => [
                        'self' => route('organizations.relationships.parent', ['id' => $this->id]),
                        'related' => route('organizations.parent', ['id' => $this->id])
                    ],
                    'data' => new OrganizationIdentifierResource($this->whenLoaded('parent'))
                ],
                'children' => [
                    'links' => [
                        'self' => route('organization.relationships.children', ['id' => $this->id]),
                        'related' => route('organization.children', ['id' => $this->id])
                    ],
                    'data' => OrganizationIdentifierResource::collection($this->whenLoaded('children'))
                ]
            ]
        ];
    }

    protected function relations()
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
