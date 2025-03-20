<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\Request;
use App\Models\Catalogos\CtlClasificacion;
use Illuminate\Validation\Rule;

class ClasificacionRequest extends Request
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'franquicia_id' => ['integer', Rule::exists('franquicias_franquicia', 'id'), 'required'],
            'clasificaciones' => [
                'required',
                'array',
                'min:1',
                'max:4',
                fn($attribute, $value, $fail) => $this->clasificacion_validator($attribute, $value, $fail)
            ],

        ];
    }

    public function clasificacion_validator($attribute, $value, $fail)
    {
        $clasificacionIds = collect($value)->pluck('clasificacion_id')->filter();

        $clasificaciones = CtlClasificacion::whereIn('id', $clasificacionIds)->get()->keyBy('id');

        collect($value)->each(function ($item, $index) use ($fail, $clasificaciones) {
            $posicion = $index + 1;

            if (!isset($item['clasificacion_id'])) {
                return $fail("El id de clasificación es requerido en la clasificación $posicion");
            }

            if (!isset($item['puntaje'])) {
                return $fail("El puntaje es requerido en la clasificación $posicion");
            }

            if (!is_int($item['clasificacion_id'])) {
                return $fail("El id de clasificación debe ser un entero en la clasificación $posicion");
            }

            if (!is_int($item['puntaje'])) {
                return $fail("El puntaje debe ser un entero en la clasificación $posicion");
            }

            $clasificacion = $clasificaciones->get($item['clasificacion_id']);

            if (!$clasificacion) {
                return $fail("La clasificación con el id " . $item['clasificacion_id'] . " no existe");
            }

            if ($item['puntaje'] > $clasificacion->puntaje_maximo) {
                return $fail("El puntaje de la clasificación " . $clasificacion->nombre . " no debe ser mayor a " . $clasificacion->puntaje_maximo);
            }

            if ($item['puntaje'] < 0) {
                return $fail("El puntaje de la clasificación " . $clasificacion->nombre . " debe ser al menos 0");
            }
        });
    }
}
