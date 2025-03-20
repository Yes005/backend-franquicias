<?php

namespace App\Http\Requests\v1;

use App\Enum\EstadoFranquiciaEnum;
use App\Http\Requests\Request;
use App\Models\Franquicia;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class VisitaCampoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function passedValidation(): void
    {
        $entidad_id = Franquicia::where('codigo_franquicia', $this->codigo_franquicia)
            ->value('id');


        $this->merge(['detalle' => Purifier::clean($this->detalle), 'entidad_id' => $entidad_id]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $required = $this->estado_id ?
            Rule::requiredIf(EstadoFranquiciaEnum::FINALIZADO->equals($this->estado_id))
            : 'nullable';

        return [
            'fecha_visita' => [$required, 'string', 'date', 'after_or_equal:2019-01-01', 'before:tomorrow'],
            'codigo_franquicia' => [
                'required',
                'string',
                'exists:franquicias_franquicia,codigo_franquicia',
            ],
            'categoria_visita_id' => [$required, 'integer', 'exists:ctl_categoria_visitas,id'],
            'detalle' => [$required, 'string'],
            'archivos' => ['nullable', 'array', 'max:25'],
            'archivos.*' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp', 'max:5000'],
            'nombres' => ['nullable', 'array', 'max:25'],
            'nombres.*' => ['nullable', 'string', 'max:150'],
            'estado_id' => ['required', 'integer', 'exists:ctl_estados,id', 'in:'
                . EstadoFranquiciaEnum::BORRADOR->value . ','
                . EstadoFranquiciaEnum::FINALIZADO->value],
        ];
    }
}
