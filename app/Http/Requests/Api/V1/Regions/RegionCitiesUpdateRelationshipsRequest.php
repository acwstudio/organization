<?php

namespace App\Http\Requests\Api\V1\Regions;

use App\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;

class RegionCitiesUpdateRelationshipsRequest extends FormRequest
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
            'data'        => ['present','array'],
            'data.*.id'   => ['required','integer','distinct','exists:cities,id'],
            'data.*.type' => ['required','string','in:cities'],
        ];
    }
}
