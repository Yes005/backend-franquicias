<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\Request;
use Illuminate\Validation\Rules\Password;

class CtlFacturaRequest extends CatalogoRequest
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
        $rules['nombre'] = ["min:3","max:150"];
        $rules['mostrar_no_factura'] = [$this->requiredIfMethod('POST'),'boolean'];

        return $rules;
    }
}
