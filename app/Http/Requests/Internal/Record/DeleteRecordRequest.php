<?php

namespace App\Http\Requests\Internal\Record;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRecordRequest extends FormRequest
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
            'record_uuid' => [
                'required',
                'exists:records,uuid'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'record_uuid' => $this->route('record')
        ]);
    }
}
