<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'max:15',
            'address' => 'max:120',
            'role' => 'required',
            'photo' => 'max:1024'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Introduceți numele de utilizator!',
            'name.max' => 'Numele utilizatorului nu poate avea mai mult de 50 de caractere!',
            'email.required' => 'Introduceți adresa de email!',
            'email.email' => 'Introduceți o adresă de email validă!',
            'phone.max' => 'Numărul de telefon nu poate avea mai mult de 15 caractere!',
            'address.max' => 'Adresa nu poate să fie formată din mai mult de 120 de caractere!',
            'role.required' => 'Trebui să dați un rol utilizatorului!',
            'photo.max' => 'Fotografia utilizatorului nu poate să ocupe mai mult de 1MB!',
        ];
    }
}
