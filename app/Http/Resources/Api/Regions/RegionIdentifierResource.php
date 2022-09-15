<?php

namespace App\Http\Resources\Api\Regions;

use App\Models\Region;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
class RegionIdentifierResource extends JsonResource
{
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
            'type' => Region::TYPE_RESOURCE
        ];
    }
}
