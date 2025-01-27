<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPostRequest extends FormRequest
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
            'title' => 'required|max:100',
            'slug' => 'required|max:255',
            'subtitle' => 'max:255',
            'presentation' => 'max:6000',
            'content' => 'max:20000',
            'image' => 'max:1024',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255'       
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Introduceți numele postării!',
            'title.max' => 'Numele postării nu poate avea mai mult de 100 de caractere!',
            'slug.required' => 'Adresa slug a postării este obligatorie!',
            'slug.max' => 'Adresa slug a postării nu poate avea mai mult de 255 de caractere!',
            'subtitle.max' => 'Subtitlul postării nu poate avea mai mult de 255 caractere!',
            'presentation.max' => 'Prezentarea postării nu poate avea mai mult de 6000 caractere!',
            'content.max' => 'Conținutul postării nu poate avea mai mult de 20000 caractere!',
            'image.max' => 'Imaginea postării nu poate să ocupe mai mult de 1MB!',
            'meta_title.max' => 'Tag-ul meta_title al postării nu poate avea mai mult de 255 caractere!',
            'meta_description.max' => 'Tag-ul meta_description al postării nu poate avea mai mult de 255 caractere!',
            'meta_keywords.max' => 'Tag-ul meta_keywords al postării nu poate avea mai mult de 255 caractere!',
        ];
    }    
}
