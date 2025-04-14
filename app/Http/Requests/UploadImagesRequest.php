<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImagesRequest extends FormRequest
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
            'images'   => ['required', 'array', 'max:6'], // max 6 fisiere
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:1024'], // max 1MB per fisier
        ];
    }

    public function messages(): array
    {
        return [
            'images.required'   => 'Te rog sa incarci cel putin o imagine.',
            'images.array'      => 'Imaginile trebuie sa fie trimise sub forma de lista.',
            'images.max'        => 'Poti incarca maxim :max imagini odata.',

            'images.*.image'    => 'Fiecare fisier trebuie sa fie o imagine.',
            'images.*.mimes'    => 'Imaginile trebuie sa fie de tip: jpeg, jpg, png sau webp.',
            'images.*.max'      => 'Fiecare imagine trebuie sa aiba maxim 1MB.',
        ];
    }
}
