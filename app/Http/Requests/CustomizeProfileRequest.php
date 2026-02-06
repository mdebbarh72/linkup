<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomizeProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'pseudo' => [
                'nullable',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9_.]+$/',
                Rule::unique('profiles', 'pseudo')->ignore($this->user()->profile->id ?? null, 'id'),
            ],

            'bio' => [
                'nullable',
                'string',
                'max:500',
            ],

            'lien_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'pseudo.unique' => 'This username is already taken.',
            'pseudo.regex'  => 'Username can only contain letters, numbers, "_" and "."',
            'lien_Photo.image'  => 'The profile picture must be an image.',
            'lien_photo.max'    => 'The image may not be larger than 2MB.',
        ];
    }
}
