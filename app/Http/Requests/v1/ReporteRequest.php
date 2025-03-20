<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ReporteRequest extends Request
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
            'fecha_inicio' => ['nullable', 'date', Rule::prohibitedIf($this->mes || $this->dia)],
            'fecha_fin' => ['nullable', 'date', Rule::prohibitedIf($this->mes || $this->dia)],
            'mes' => [
                'nullable', 'date',
                Rule::prohibitedIf($this->fecha_inicio || $this->fecha_fin || $this->dia)
            ],
            'dia' => [
                'nullable', 'date',
                Rule::prohibitedIf($this->fecha_inicio || $this->fecha_fin || $this->mes)
            ],
        ];
    }
}
