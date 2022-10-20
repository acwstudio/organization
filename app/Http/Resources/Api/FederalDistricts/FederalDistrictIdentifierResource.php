<?php

namespace App\Http\Resources\Api\FederalDistricts;

use App\Models\FederalDistrict;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FederalDistrict */
class FederalDistrictIdentifierResource extends JsonResource
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
            'id'   => $this->id,
            'type' => FederalDistrict::TYPE_RESOURCE
        ];
    }
}
