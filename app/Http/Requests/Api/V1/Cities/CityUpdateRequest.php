<?php

namespace App\Http\Requests\Api\V1\Cities;

use App\Models\City;
use App\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;

class CityUpdateRequest extends FormRequest
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
            'data.type'                           => ['required','string','in:' . City::TYPE_RESOURCE],
            'data.attributes'                     => ['required','array'],
            'data.attributes.federal_district_id' => ['sometimes','integer'],
            'data.attributes.name'                => ['sometimes','string'],
            'data.attributes.description'         => ['sometimes','string'],
            'data.attributes.slug'                => ['prohibited'],
            'data.attributes.active'              => ['sometimes','boolean'],
            // relationships
            'data.relationships'                           => ['sometimes','required','array'],
            'data.relationships.organizations'             => ['sometimes','required','array'],
            'data.relationships.organizations.data'        => ['sometimes','required','array'],
            'data.relationships.organizations.data.*'      => ['sometimes','required','array'],
            'data.relationships.organizations.data.*.type' => ['present','string','in:' . Organization::TYPE_RESOURCE],
            'data.relationships.organizations.data.*.id'   => [
                'present','string', 'distinct', 'exists:' . Organization::TYPE_RESOURCE . ',id'
            ],
        ];
    }
}
