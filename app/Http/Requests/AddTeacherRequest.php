<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTeacherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:30|min:5',
            'email' => 'required|email:rfc,dns|max:30',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле фамилия обязательное для заполнения',
            'name.text' => 'Поле фамилия не поддерживает данный формат',
            'name.max' => 'Поле фамилия максимальная длина значения 30 символов',
            'name.min' => 'Поле фамилия минимальная длина значения 5 символов',
            'email.required' => 'Поле почта обязательное для заполнения',
            'email.email' => 'Поле почта не поддерживает данный формат',
            'email.max' => 'Поле почта максимальная длина значения 30 символов',
            'password.required' => 'Поле пароль обязательное для заполнения',
            'password.string' => 'Поле пароль не поддерживает данный формат',
        ];
    }
}
