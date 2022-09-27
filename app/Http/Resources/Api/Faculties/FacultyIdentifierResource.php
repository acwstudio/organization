<?php

namespace App\Http\Resources\Api\Faculties;

use App\Models\Faculty;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Faculty */
class FacultyIdentifierResource extends JsonResource
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
            'type' => Faculty::TYPE_RESOURCE,
        ];
    }
}
