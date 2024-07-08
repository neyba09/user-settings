<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateLoginRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *      required={"email", "password"},
     *      schema="ValidateLoginRequest",
     *      @OA\Property(property="email", type="string",  example="egorov@mail.ru", description="Email пользователя"),
     *      @OA\Property(property="password", type="string",  example="123QWEqwe1!", description="Пароль"),
     * )
     *
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'email.email' => 'Должен быть указан действительный адрес электронной почты',
            'email.required'  => 'Вы не указали email',
            'password.required'  => 'Вы не указали пароль',
        ];
    }
}

