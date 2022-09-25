<?php

namespace App\Http\Resources\Api\Organizations;

use App\Http\Resources\Api\Cities\CityIdentifierResource;
use App\Http\Resources\Api\Cities\CityResource;
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
                        'self' => '',
                        'related' => ''
                    ],
                    'data' => new CityIdentifierResource($this->whenLoaded('city'))
                ],
                'organizationType' => [
                    'links' => [
                        'self' => '',
                        'related' => ''
                    ],
                    'data' => new OrganizationTypeIdentifierResource($this->whenLoaded('organizationType'))
                ]
            ]
        ];
    }

    protected function relations()
    {
        return [
            CityResource::class             => $this->whenLoaded('city'),
            OrganizationTypeResource::class => $this->whenLoaded('organizationType')
        ];
    }
}
