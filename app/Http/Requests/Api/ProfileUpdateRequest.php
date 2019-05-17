<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'string|max:255',
            'phone' => 'integer|min:9',
            'biography' => 'sometimes|max:1000',
            'position' => 'sometimes|max:255',
            'image' => 'file|mimes:jpeg,jpg,png|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Имя не должно превышать 255 символов!',
            'phone.integer' => 'Телефон не должен содержать строковых символов!',
            'phone.min' => 'Неверно введен номер телефона!',
            'biography.max' => 'Информация о биографии не должна превышать 1000 символов!',
            'position.max' => 'Информация о биографии не должна превышать 255 символов!',
            'image.mimes' => 'Выберите фото подходящего формата (peg,jpg,png)',
            'image.max' => 'Размер фото не должен превышать 3mb',
        ];
    }
}
