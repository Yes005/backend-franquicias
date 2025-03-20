<?php
namespace App\Enum;

use App\Models\Catalogos\CtlEstado;

enum EstadoFranquiciaEnum: int
{

    case BORRADOR = 1;
    case REVISION = 2;

    case OBSERVADA = 3;
    case SOLVENTADA = 4;
    case ANULADA = 5;

    case APROBADA = 6;
    case FIRMADA = 7;
    case FINALIZADO = 8;


    public function name(): string
    {

        return match ($this) {
            self::BORRADOR => 'Borrador',
            self::REVISION => 'Revisión',
            self::OBSERVADA => 'Observada',
            self::SOLVENTADA => 'Solventada',
            self::ANULADA => 'Anulada',
            self::APROBADA => 'Aprobada',
            self::FIRMADA => 'Firmada',
            self::FINALIZADO => 'Finalizado',
        };

    }

    public function equals(int $estadoId): bool
    {
        return $this->value === $estadoId;
    }


    public static function getEstadoId($estadoNombre)
    {
        $estado = CtlEstado::where('nombre', $estadoNombre)->first();

        if ($estado) {
            return $estado->id;
        }

        return null;
    }
}
