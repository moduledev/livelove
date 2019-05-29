<?php

namespace App\Http\Requests;

use App\Rules\IsPastStarted;
use Carbon\Carbon;
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
            'started' => 'required|date|after:yesterday',
            'finished' => 'required|date|after_or_equal:started',
            'location' => 'required|max:255|string',
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
            'location.required' => 'Поле место проведения обязательно к заполнению!',
            'location.max' => 'Поле место проведения не должно содержать более 255 символов!',
        ];
    }
}
