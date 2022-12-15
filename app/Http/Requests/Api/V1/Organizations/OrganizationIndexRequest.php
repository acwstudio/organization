<?php

namespace App\Http\Requests\Api\V1\Organizations;

use App\Rules\CorrectQueryFieldsParameterRule;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationIndexRequest extends FormRequest
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
     * This ensures that the required query parameters are in place.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'fields'        => ['sometimes','required'],
            'fields.organizations' => [
                'sometimes','required',
                new CorrectQueryFieldsParameterRule('parent_id,city_id,organization_type_id,id')
            ]
        ];
    }
}
