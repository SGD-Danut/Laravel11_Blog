<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'title' => 'nullable|max:250',
            'description' => 'nullable|max:250',
            'position' => 'integer',
            'image' => 'nullable|image|max:1024'
        ];
    }

    public function messages(): array
    {
        return [
            'title.max'   => 'Titlul imaginii nu poate avea mai mult de :max caractere.',
            'description.max'   => 'Descrierea imaginii nu poate avea mai mult de :max caractere.',
            'position'   => 'Positia imaginii trebuie să fie un număr întreg.',
            'image.max' => 'Imaginea nu poate să aibă mai multe de 1MB.'
        ];
    }
}
