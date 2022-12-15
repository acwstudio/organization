<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Rules\CorrectQueryFieldsParameterRule;
use Illuminate\Foundation\Http\FormRequest;

class RegionIndexRequest extends FormRequest
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
    public function rules()
    {
        return [
            'fields'                    => ['sometimes','required'],
            'fields.regions' => [
                'sometimes','required', new CorrectQueryFieldsParameterRule('federal_district_id,id')
            ]
        ];
    }
}
