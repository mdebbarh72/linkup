<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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

            'content' => ['nullable', 'string', 'max:3000'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],   
        ];
    }

    public function withvalidator($validator): void
    {
        $validator->after(
            function ($validator) {
                $hasText= $this->filled('content');
                $hasImage= $this->hasFile('images');

                if(!$hasText && !$hasImage)
                {
                    $validator->errors()->add('content', 'Post can\'t be empty. Please add text or an image.');
                }
            }
        );
    }
}
