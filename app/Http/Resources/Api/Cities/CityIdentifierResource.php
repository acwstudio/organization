<?php

namespace App\Http\Resources\Api\Cities;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin City */
class CityIdentifierResource extends JsonResource
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
            'type' => City::TYPE_RESOURCE
        ];
    }
}
