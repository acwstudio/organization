<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Models\FederalDistrict;
use Illuminate\Foundation\Http\FormRequest;

class RegionsFederalDistrictUpdateRelationshipsRequest extends FormRequest
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
            'data'      => ['required', 'array'],
            'data.id'   => ['required','integer','exists:federal_districts,id'],
            'data.type' => ['required','string','in:' . FederalDistrict::TYPE_RESOURCE],
        ];
    }
}
