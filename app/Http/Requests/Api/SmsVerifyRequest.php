<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SmsVerifyRequest extends FormRequest
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
            'phone' => 'required|integer|max:13',
            'code' => 'required|integer|min:4',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Телефон обязателен к заполнению!',
            'phone.integer' => 'Телефон не должен содержать строковых символов!',
            'phone.max' => 'Неверно введен номер телефона!',
            'code.required' => 'Введите полученый по sms код!',
            'code.integer' => 'Код не должен содержать строковых символов!',
            'code.min' => 'Неверно введен код!',
        ];
    }
}
