<?php

namespace App\Http\Requests\Internal\Record;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CreateRecordRequest extends FormRequest
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
                Rule::unique('records', 'name'),
                'string',
                'min:5',
                'max:120'
            ],
            'default_search_available' => [
                'nullable',
                'boolean'
            ],
            'path' => [
                'required',
                'string',
                function ($attr, $value, $fail) {
                    $path = Storage::disk('local')->path($value);

                    if (!file_exists($path)) {
                        $fail('File does not exists');
                    }
                }
            ],
            'tags' => [
                'nullable',
                'array'
            ],
            'tags.*' => [
                'exists:tags,uuid',
                'distinct'
            ]
        ];
    }
}
