<?php

namespace App\Http\Requests\Start;

use Illuminate\Foundation\Http\FormRequest;

class StartFormSubmitRequest extends FormRequest
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
            'username' => [
                'required',
                // unique:table,column,except,idColumn
                'unique:users',
                'min:4',
                'max:60',
                'alpha_dash'
            ],
            'email' => [
                'required',
                'unique:users',
                'email'
            ],
            'password' => [
                'required',
                'min:8',
                'max:40'
            ],
            'first_name' => [
                'required',
                'min:2',
                'max:40',
                'alpha'
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:40',
                'alpha'
            ]
        ];
    }
}
