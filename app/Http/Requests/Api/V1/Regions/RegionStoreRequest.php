<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Models\City;
use App\Models\FederalDistrict;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class RegionStoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'data'                                => ['required','array'],
            'data.type'                           => ['required','string','in:' . Region::TYPE_RESOURCE],
            'data.attributes'                     => ['required','array'],
            'data.attributes.federal_district_id' => ['sometimes','integer','nullable','exists:federal_districts,id'],
            'data.attributes.name'                => ['required','string'],
            'data.attributes.description'         => ['required','string'],
            'data.attributes.slug'                => ['prohibited'],
            'data.attributes.active'              => ['required','boolean'],
            // relationships
            'data.relationships'                    => ['sometimes','required','array'],
            // cities one-to-many
            'data.relationships.cities'             => ['sometimes','required','array'],
            'data.relationships.cities.data'        => ['sometimes','required','array'],
            'data.relationships.cities.data.*'      => ['sometimes','required','array'],
            'data.relationships.cities.data.*.type' => ['present','required','string','in:' . City::TYPE_RESOURCE],
            'data.relationships.cities.data.*.id'   => ['present','required','integer', 'distinct', 'exists:cities,id'],
            // federalDistrict many-to-one
            'data.relationships.federalDistrict'           => ['sometimes','required','array'],
            'data.relationships.federalDistrict.data'      => ['sometimes','required','array'],
            'data.relationships.federalDistrict.data.type' => ['sometimes','required','string','in:' . FederalDistrict::TYPE_RESOURCE],
            'data.relationships.federalDistrict.data.id'   => ['sometimes','required','integer', 'exists:federal_districts,id'],
        ];
    }
}
