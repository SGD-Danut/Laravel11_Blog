<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|min:8|same:new_password'
        ];
    }

    public function messages() {
        return [
            'old_password.required' => 'Introduceți parola dumneavoastră actuală!',
            'old_password.min' => 'Parola actuală trebuie să aibă cel puțin 8 caractere!',
            'new_password.required' => 'Introduceți noua dumneavoastră parolă!',
            'new_password.min' => 'Parola nouă trebuie să fie formată din cel puțin 8 caractere!',
            'new_password_confirmation.required' => 'Introduceți din nou noua dumneavoastră parolă!',
            'new_password_confirmation.min' => 'Parola nouă introdusă din nou trebuie să aibă cel puțin 8 caractere!',
            'password.same' => 'Parola confirmată nu este corectă!'
        ];
    }
    
}
