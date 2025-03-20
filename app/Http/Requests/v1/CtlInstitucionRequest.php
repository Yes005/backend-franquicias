<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CtlInstitucionRequest extends CatalogoRequest
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
        $rules = parent::rules();
        $rules['representante_legal'] = [$this->requiredIfMethod('POST'),'string'];
        $rules['fecha_inicio_junta_directiva'] = ['required','date'];
        $rules['fecha_fin_junta_directiva'] = ['required','date'];

        return $rules;
    }
}
