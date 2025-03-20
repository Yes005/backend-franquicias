<?php

namespace App\Http\Requests\v1;

use App\Models\MntClasificacionDocumentos;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClasificacionObservacionRequest extends FormRequest
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
            'franquicia_id' => ['integer', Rule::exists('franquicias_franquicia', 'id'), 'required'],
            'archivo' => [
                'file',
                'mimes:png,jpeg,jpg,pdf',
                'max:5120'
            ],
            'comentario' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $attributes = [];

        if ($this->hasFile('archivo')) {
            $file = $this->file('archivo');
            $originalName = $file->getClientOriginalName();
            $attributes['archivo'] = $originalName;
        }

        return $attributes;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'archivo.mimes' => 'El archivo :attribute debe ser un archivo de tipo: PNG, JPG, JPEG o PDF.',
            'archivo.max' => 'El archivo :attribute no debe superar los 5MB.',
        ];
    }
}
