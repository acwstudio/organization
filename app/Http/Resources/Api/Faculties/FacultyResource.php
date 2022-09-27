<?php

namespace App\Http\Resources\Api\Faculties;

use App\Http\Resources\Api\Organizations\OrganizationResource;
use App\Http\Resources\Api\OrganizationTypes\OrganizationTypeIdentifierResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\Faculty;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Faculty */
class FacultyResource extends JsonResource
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
            'type' => Faculty::TYPE_RESOURCE,
            'attributes' => [
                'organization_id' => $this->organization_id,
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
                'active' => $this->active,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'organization' => [
                    'links' => [
                        'self' => route('faculties.relationships.organization', ['id' => $this->id]),
                        'related' => route('faculties.organization', ['id' => $this->id]),
                    ],
                    'data' => new OrganizationTypeIdentifierResource($this->whenLoaded('organization'))
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    protected function relations(): array
    {
        return [
            OrganizationResource::class => $this->whenLoaded('organization'),
        ];
    }
}
