<?php

namespace App\Http\Requests\Internal\Tag;

use Illuminate\Foundation\Http\FormRequest;

class AddTagFromInputRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'alpha_dash_spaces_cyrillic',
                'min:3',
                'max:12'
            ]
        ];
    }
}
