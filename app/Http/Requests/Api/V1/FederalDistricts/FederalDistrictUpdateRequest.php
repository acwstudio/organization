<?php

namespace App\Http\Requests\Api\V1\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class FederalDistrictUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data'                        => ['required','array'],
            'data.type'                   => ['required','string','in:' . FederalDistrict::TYPE_RESOURCE],
            // attributes
            'data.attributes'             => ['present','array'],
            'data.attributes.name'        => ['sometimes','string'],
            'data.attributes.description' => ['sometimes','string'],
            'data.attributes.slug'        => ['prohibited'],
            'data.attributes.active'      => ['sometimes','boolean'],
            // relationships
            'data.relationships'                     => ['sometimes','required','array'],
            // regions
            'data.relationships.regions'             => ['sometimes','required','array'],
            'data.relationships.regions.data'        => ['sometimes','required','array'],
            'data.relationships.regions.data.*'      => ['sometimes','required','array'],
            'data.relationships.regions.data.*.type' => ['present','required','string','in:' . Region::TYPE_RESOURCE],
            'data.relationships.regions.data.*.id'   => ['present','required','integer','distinct', 'exists:regions,id'],
        ];
    }
}
