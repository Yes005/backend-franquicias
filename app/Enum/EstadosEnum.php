<?php
namespace App\Enum;
use ReflectionClass;
enum EstadosEnum: string {
    case ACTIVE= "active";
    case INACTIVE= "inactive";
    case ALL = "all";

    public static function toArray(): array
    {
        return (new ReflectionClass(self::class))->getConstants();
    }
}



