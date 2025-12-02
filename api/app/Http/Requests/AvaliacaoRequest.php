<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvaliacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ponto_id'   => ['required', 'exists:pontos_turisticos,id'],
            'usuario_id' => ['required', 'exists:users,id'],
            'nota'       => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string'],
        ];
    }
}
