<?php

namespace App\Http\Resources\Api\FederalDistricts;

use App\Http\Resources\Api\Regions\RegionCollection;
use App\Http\Resources\Api\Regions\RegionIdentifierResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\FederalDistrict;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FederalDistrict */
class FederalDistrictResource extends JsonResource
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
            'type'       => FederalDistrict::TYPE_RESOURCE,
            'attributes' => [
                'name'        => $this->name,
                'description' => $this->description,
                'slug'        => $this->slug,
                'active'      => $this->active,
                'created_at'  => $this->created_at,
                'updated_at'  => $this->updated_at,
            ],
            'relationships' => [
                'regions' => [
                    'links' => [
                        'self'    => route('federal-district.relationships.regions', ['id' => $this->id]),
                        'related' => route('federal-district.regions', ['id' => $this->id]),
                    ],
                    'data' => RegionIdentifierResource::collection($this->whenLoaded('regions'))
                ]
            ]
        ];
    }

    protected function relations()
    {
        return [
            RegionCollection::class => $this->whenLoaded('regions')
        ];
    }
}
