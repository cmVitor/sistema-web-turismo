<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'texto' => ['required', 'string', 'max:2000'],
            'imagens.*' => ['nullable', 'image', 'max:5120'], // max 5MB por imagem
        ];
    }
}
