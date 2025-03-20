<?php

namespace App\Enum;

use ReflectionClass;

enum TagsEnum: string {

    case FRANQUICIAS = 'Franquicias';
    case ADUANAS = 'Aduanas';
    case OFICIALES = 'Oficiales';
    case FACTURAS = 'Tipo de franquicia';
    case FIRMANTE = 'Firmante';
    case USUARIOS = 'Usuarios';
    case ROLES = 'Roles';
    case IDENTIFICADOR_GESTION = 'Identificador de gestión';
    case REPORTES = 'Reportes';
    case CLASES = 'Clases';
    case INSTITUCIONES = 'Instituciones';
    case RUTAS = 'Rutas';
    case PERMISOS = 'Permisos';
    case CLASIFICACION = 'Clasificación';
    case VISITAS_CAMPO = 'Visitas de campo';

    public static function toArray(): array
    {
        return (new ReflectionClass(self::class))->getConstants();
    }


}
