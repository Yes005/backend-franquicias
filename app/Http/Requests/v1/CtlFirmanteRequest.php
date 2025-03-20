<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CtlFirmanteRequest extends FormRequest
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
            'firma' =>  ['required', 'string', 'max:100'],
            'cargo' => ['required','string', 'max:100'],
            'acuerdo_ejecutivo' => ['required','string', 'max:100'],
            'fecha_inicio_validez' => ['required','date'],
            'fecha_fin_validez' => ['required','date']
        ];
    }
}
