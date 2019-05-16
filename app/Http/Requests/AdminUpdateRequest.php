<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Имя обязательно к заполнению!',
            'name.max' => 'Имя не должно содержать больше 255 символов!',
            'email.required' => 'E-mail обязателен к заполнению!',
            'email.max' => 'E-mail не должно содержать больше 255 символов!!',
            'password.required' => 'Введите пароль!',
        ];
    }
}
