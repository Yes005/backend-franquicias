<?php

namespace App\Enum;

use ReflectionClass;

enum DocumentEnum: string
{
    case CONC_EMBARQUE = "conoc_de_embarque_no";
    case DMTI = "nota_de_pedido_no";
    case AEREA = "no_guia_aerea";
    case CARTE_PORTE = "carta_de_porte_no";
    case MERCANCIAS = "inf_de_mercaderias_rec_no";
    case ITINERARIO = "itinerario";

    public static function toArray(): array
    {
        return (new ReflectionClass(self::class))->getConstants();
    }

    public static function toValues(): array
    {
        return collect(self::toArray())->map->value
            ->values()->toArray();
    }
}
