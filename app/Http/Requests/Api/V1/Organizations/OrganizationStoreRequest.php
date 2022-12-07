<?php

namespace App\Http\Requests\Api\V1\Organizations;

use App\Models\Faculty;
use App\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationStoreRequest extends FormRequest
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
            'data'                                 => ['required','array'],
            'data.type'                            => ['required','string','in:' . Organization::TYPE_RESOURCE],
            'data.attributes'                      => ['required','array'],
            'data.attributes.parent_id'            => ['sometimes','string'],
            'data.attributes.city_id'              => ['required','integer'],
            'data.attributes.organization_type_id' => ['required','integer'],
            'data.attributes.name'                 => ['required','string'],
            'data.attributes.abbreviation'         => ['required','string'],
            'data.attributes.description'          => ['required','string'],
            'data.attributes.site'                 => ['required','string'],
            'data.attributes.email'                => ['required','string','email'],
            'data.attributes.phone'                => ['required','string'],
            'data.attributes.address'              => ['required','string'],
            'data.attributes.slug'                 => ['prohibited'],
            'data.attributes.plaque_image'         => ['required','string'],
            'data.attributes.preview_image'        => ['required','string'],
            'data.attributes.base_image'           => ['required','string'],
            // relationships
            'data.relationships'                   => [
                'sometimes','required','array:faculties,parent,children,city,organizationType'
            ],
            // organizations
            'data.relationships.faculties'             => ['sometimes','required','array'],
            'data.relationships.faculties.data'        => ['sometimes','required','array'],
            'data.relationships.faculties.data.*'      => ['sometimes','required','array'],
            'data.relationships.faculties.data.*.type' => ['present','string','in:' . Faculty::TYPE_RESOURCE],
            'data.relationships.faculties.data.*.id'   => ['present','integer', 'distinct', 'exists:faculties,id'],
        ];
    }
}
