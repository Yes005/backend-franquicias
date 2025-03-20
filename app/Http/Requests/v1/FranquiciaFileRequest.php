<?php

namespace App\Http\Requests\v1;

use App\Enum\EstadoFranquiciaEnum;
use App\Http\Requests\Request;
use App\Models\Franquicia;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FranquiciaFileRequest extends Request
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
            'archivo' => 'required|file|mimes:png,jpeg,jpg,pdf|max:5120',
            'franquicia_id' => 'required|integer|exists:franquicias_franquicia,id'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->hasFile(['archivo', 'franquicia_id'])) {
                $file = $this->file('archivo');
                $originalName = $file->getClientOriginalName();
                $franquicia = Franquicia::find($this->franquicia_id);

                $estadoAprobada = EstadoFranquiciaEnum::getEstadoId('Aprobada');

                if ($franquicia->estado != $estadoAprobada) {
                    throw new BadRequestException('No se puede subir archivos a una franquicia que no ha sido aprobada');
                }

                $encabezado = $franquicia->codigo_franquicia . '_';
                $archivo = $encabezado . $originalName;
                $maxArchivoLength = 100;
                $availableLength = $maxArchivoLength - strlen($encabezado);

                if (strlen($archivo) > $maxArchivoLength) {
                    $validator->errors()->add('archivo', 'El nombre del archivo no debe superar los ' . $maxArchivoLength . ' caracteres.');
                }

                if (strlen($archivo) > $maxArchivoLength) {
                    $validator->errors()->add('archivo', 'El nombre del archivo tiene ' . strlen($originalName) . ' caracteres. Puede tener un máximo de ' . $availableLength . ' caracteres, ya que se guarda con el código de franquicia.');
                }
            }
        });
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
            'archivo.mimes' => 'El archivo :attribute debe ser un archivo de tipo: pdf, jpg, jpeg, png.',
            'archivo.max' => 'El archivo :attribute no debe superar los 5MB.',
        ];
    }
}
