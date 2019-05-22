<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramStoreRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:3072',
            'started' => 'required',
            'finished' => 'required',
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
            'name.required' => 'Название обязателено к заполнению!',
            'description.required' => 'Описание !',
            'image.required' => 'Изображение обязателено!',
            'image.max' => 'Изображение не должно быть больше 3 mb!',
            'image.mimes' => 'Доступны для загрузки jpeg,jpg,png!',
            'started.required' => 'Поле старт программы обязательно к заполнению!',
            'finished.required' => 'Поле окончание программы обязательно к заполнению!',
        ];
    }
}
