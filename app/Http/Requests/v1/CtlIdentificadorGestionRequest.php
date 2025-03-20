<?php

namespace App\Http\Requests\v1;
use App\Http\Requests\Request;

class CtlIdentificadorGestionRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "codigo" => [$this->requiredIfMethod('POST'), 'string', 'max:3']
        ];
    }
}
