<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospedagemRequest extends FormRequest
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
            'ponto_id'     => ['required', 'exists:pontos_turisticos,id'],
            'nome'         => ['required', 'string', 'max:255'],
            'endereco'     => ['required', 'string'],
            'telefone'     => ['nullable', 'string'],
            'preco_medio'  => ['nullable', 'numeric', 'min:0'],
            'tipo'         => ['required', 'in:hotel,pousada,hostel'],
            'link_reserva' => ['nullable', 'url'],
        ];
    }
}
