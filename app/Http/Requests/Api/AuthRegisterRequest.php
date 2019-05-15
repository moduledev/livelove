<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|integer|min:9',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Имя обязательно к заполнению!',
            'name.max' => 'Имя не должно превышать 255 символов!',
            'phone.required' => 'Телефон обязателен к заполнению!',
            'phone.min' => 'Неверно введен номер телефона!',
        ];
    }
}
