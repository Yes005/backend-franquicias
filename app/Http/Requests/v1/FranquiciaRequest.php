<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;


class FranquiciaRequest extends Request
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
            'tipo' => [$this->requiredIfMethod('POST'), 'exists:ctl_entidad,id'],
            'institucion_id' => ['exclude_if:tipo,2', 'required_if:tipo,1', 'exists:franquicias_institucion,id'],
            'oficial_id' => ['exclude_if:tipo,1', 'required_if:tipo,2', 'exists:franquicias_oficial,id'],
            'aduana_id' => [$this->requiredIfMethod('POST'), 'exists:franquicias_aduana,id'],
            'no_guia_aerea' => ['nullable', 'max:50', 'min:4'],
            'conoc_de_embarque_no' => ['nullable', 'max:50', 'min:4'],
            'inf_de_mercaderias_rec_no' => ['nullable', 'max:50', 'min:4'],
            'carta_de_porte_no' => ['nullable', 'max:50', 'min:4'],
            'nota_de_pedido_no' => ['nullable', 'max:50', 'min:4'],
            'fecha' => [$this->requiredIfMethod('POST'), 'date'],
            'itinerario' => ['nullable', 'max:500', 'min:4'],
            'factura_comercial_id' => [$this->requiredIfMethod('POST'), 'exists:franquicias_facturacomercial,id'],
            'bultos' => [$this->requiredIfMethod('POST'), 'integer'],
            'clase_id' => [$this->requiredIfMethod('POST'), 'exists:franquicias_clase,id'],
            'comentario' => [$this->requiredIfMethod('POST'), 'max:500', 'min:4'], //contenido
            'nota' => ['nullable', 'max:500', 'min:4'],
            'observacion' => ['nullable', 'max:500', 'min:4'],
            'no_factura' => ['nullable', 'max:150'],
            'destino' => [$this->requiredIfMethod('POST'), 'max:500', 'min:4'],
            'duca' => ['nullable', 'max:150', 'min:4', 'string']
        ];
    }


    // Custom validation

    // Valida que ciertos campos tengan al menos un valor
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (str_contains($this->path(), 'borrador')) {
                return;
            }

            $camposRequeridos = [
                'duca',
                'nota_de_pedido_no',
                'itinerario',
                'no_guia_aerea',
                'carta_de_porte_no',
                'conoc_de_embarque_no',
                'inf_de_mercaderias_rec_no'
            ];

            $tieneValor = false;
            foreach ($camposRequeridos as $campo) {
                if (!empty($this->input($campo))) {
                    $tieneValor = true;
                    break;
                }
            }

            if (!$tieneValor) {
                $validator->errors()->add(
                    'campos_requeridos',
                    'Debe completar la información de uno de los campos: DUCA, DMTI, Itinerario, Guía aérea no., Carta de porte no., Conocimiento de embarque no., Información de mercaderías recibidas no.'
                );
            }
        });
    }
}
