<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddContactMessageRequest extends FormRequest
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
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'email'    => ['required', 'email', 'max:150'],
            'subject'  => ['required', 'string', 'min:3', 'max:150'],
            'category' => ['required', 'in:general,tehnic,despre-postari'],
            'message'  => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Numele este obligatoriu.',
            'name.string'       => 'Numele trebuie să fie un text.',
            'name.min'          => 'Numele trebuie să aibă cel puțin :min caractere.',
            'name.max'          => 'Numele nu poate avea mai mult de :max caractere.',

            'email.required'    => 'Adresa de email este obligatorie.',
            'email.email'       => 'Adresa de email nu este validă.',
            'email.max'         => 'Adresa de email nu poate avea mai mult de :max caractere.',

            'subject.required'  => 'Subiectul este obligatoriu.',
            'subject.string'    => 'Subiectul trebuie să fie un text.',
            'subject.min'       => 'Subiectul trebuie să aibă cel puțin :min caractere.',
            'subject.max'       => 'Subiectul nu poate avea mai mult de :max caractere.',

            'category.required' => 'Categoria este obligatorie.',
            'category.in'       => 'Categoria selectată nu este validă.',

            'message.required'  => 'Mesajul este obligatoriu.',
            'message.string'    => 'Mesajul trebuie să fie un text.',
            'message.min'       => 'Mesajul trebuie să aibă cel puțin :min caractere.',
            'message.max'       => 'Mesajul nu poate avea mai mult de :max caractere.',
        ];
    }
}
