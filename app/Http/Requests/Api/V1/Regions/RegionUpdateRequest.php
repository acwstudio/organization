<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Models\City;
use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class RegionUpdateRequest extends FormRequest
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
            'data'                                => ['required','array'],
            'data.type'                           => ['required','string','in:' . Region::TYPE_RESOURCE],
            'data.attributes'                     => ['required','array'],
            'data.attributes.federal_district_id' => ['sometimes','integer'],
            'data.attributes.name'                => ['sometimes','string'],
            'data.attributes.description'         => ['sometimes','string'],
            'data.attributes.slug'                => ['prohibited'],
            'data.attributes.active'              => ['sometimes','boolean'],
            // relationships
            'data.relationships'                    => ['sometimes','required','array'],
            'data.relationships.cities'             => ['sometimes','required','array'],
            'data.relationships.cities.data'        => ['sometimes','required','array'],
            'data.relationships.cities.data.*'      => ['sometimes','required','array'],
            'data.relationships.cities.data.*.type' => ['present','string','in:' . City::TYPE_RESOURCE],
            'data.relationships.cities.data.*.id'   => ['present','integer', 'distinct', 'exists:cities,id'],
            // federalDistrict
            'data.relationships.federalDistrict'           => ['sometimes','required','array'],
            'data.relationships.federalDistrict.data'      => ['sometimes','required','array'],
            'data.relationships.federalDistrict.data.type' => ['present','string','in:' . FederalDistrict::TYPE_RESOURCE],
            'data.relationships.federalDistrict.data.id'   => ['present','integer', 'exists:federal_districts,id'],
        ];
    }
}
