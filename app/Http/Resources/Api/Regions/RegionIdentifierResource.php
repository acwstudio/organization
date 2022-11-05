<?php

namespace App\Http\Resources\Api\Regions;

use App\Models\Region;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
class RegionIdentifierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'type' => Region::TYPE_RESOURCE
        ];
    }
}
