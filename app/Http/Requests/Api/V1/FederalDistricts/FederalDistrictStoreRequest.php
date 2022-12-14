<?php

namespace App\Http\Requests\Api\V1\FederalDistricts;

use App\Models\FederalDistrict;
use App\Models\Region;
use App\Rules\ForeignKeyNullRule;
use Illuminate\Foundation\Http\FormRequest;

class FederalDistrictStoreRequest extends FormRequest
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
            'data.attributes'             => ['required','array'],
            'data.attributes.name'        => ['required','string'],
            'data.attributes.description' => ['required','string'],
            'data.attributes.slug'        => ['prohibited'],
            'data.attributes.active'      => ['required','boolean'],
            // relationships
            'data.relationships'                     => ['sometimes','required','array:regions'],
            // regions one-to-many
            'data.relationships.regions'             => ['sometimes','required','array:data'],
            'data.relationships.regions.data'        => ['sometimes','required','array'],
            'data.relationships.regions.data.*.type' => ['present','string','in:' . Region::TYPE_RESOURCE],
            'data.relationships.regions.data.*.id'   => [
                'present','integer', 'distinct', 'exists:regions,id',
                new ForeignKeyNullRule(Region::class, 'federal_district_id')
            ],
        ];
    }
}
