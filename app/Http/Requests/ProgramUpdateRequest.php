<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramUpdateRequest extends FormRequest
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
            'title' => 'string|max:255',
            'description' => 'string|max:1000',
            'image' => 'mimes:jpeg,jpg,png|max:3072',
            'started' => 'required',
            'finished' => 'required',
            'location' => 'required|max:255|string',
        ];
    }
}
