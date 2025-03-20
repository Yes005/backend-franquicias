<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MntRolPermisosSeeder extends Seeder
{

    private static function getPermisoId($name)
    {
        return DB::table('ctl_permisos')->where('nombre', $name)->first()->id ?? null;
    }

    private static function getRolId($name)
    {
        return DB::table('ctl_roles')->where('nombre', $name)->first()->id ?? null;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolPermiso = [
            [
                "id" => 1,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_RECUPERAR_CONTRASENIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_CONFIGURACIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 4,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FACTURA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 5,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 6,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 7,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 8,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FACTURAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 9,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FACTURA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 10,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FACTURA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 11,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_INSTITUCIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 12,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_OFICIAL->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 13,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_CLASE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 14,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_IDENTIFICADOR_GESTION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 15,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_CLASES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 16,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_CLASE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 17,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_CLASE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 18,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_OFICIALES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 19,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_OFICIAL->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 20,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_OFICIAL->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 21,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_INSTITUCIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 22,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_INSTITUCION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 23,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_INSTITUCION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 24,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_IDENTIFICADOR_GESTION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 25,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_IDENTIFICADOR_GESTION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 26,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_IDENTIFICADOR_GESTION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 27,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FIRMA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 28,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FIRMANTES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 29,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FIRMANTE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 30,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FIRMANTE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 31,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 32,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FIRMA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 33,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FIRMANTES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 34,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FIRMANTE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 35,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FIRMANTE->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 36,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 37,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_USER->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 38,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_USER->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 39,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_USERS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 40,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::DESBLOQUEAR_USER->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 41,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 42,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 43,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FRANQUICIAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 44,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_DETALLE_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 45,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 46,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 47,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_DETALLE_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 48,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_PERMISOS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 49,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_ROLES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 50,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_ROL->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 51,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_ROL->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 52,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_ROLES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 53,
                "rol_id" => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_PERMISOS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 54,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FRANQUICIAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 55,
                'rol_id' => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_USUARIOS->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 56,
                'rol_id' => $this->getRolId('Administrador'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_USUARIOS_ROLES->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 57,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 58,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_ADUANA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 59,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FACTURAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 60,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_FACTURAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 61,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_BORRADOR->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 62,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_BORRADOR->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 63,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_INSTITUCIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 64,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_INSTITUCIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 65,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_CLASES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 66,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_CLASES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 67,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_OFICIALES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 68,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_OFICIALES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 69,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::OBSERVAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 70,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ENVIAR_FRANQUICIA_REVISION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 71,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::SOLVENTAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 72,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_REPORTES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 73,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::SUBIR_ARCHIVOS_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 74,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_ARCHIVOS_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 75,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_ARCHIVOS_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 76,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ELIMINAR_ARCHIVOS_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 77,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ANULAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 78,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::APROBAR_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 79,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::PREVISUALIZAR_DOCUMENTO_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 80,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_OBSERVACION_FRANQUICIA->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 81,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::GESTIONAR_FECHAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 82,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::GENERAR_REPORTES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 83,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::GENERAR_REPORTES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 84,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::GESTIONAR_FECHAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 85,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::PUNTUAR_FRANQUICIAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 86,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_PUNTAJE_FRANQUICIAS->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 87,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::GUARDAR_OBSERVACION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 88,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::LISTAR_OBSERVACIONES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 89,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::PREVISUALIZAR_ARCHIVO_OBSERVACION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 90,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::ELIMINAR_OBSERVACION->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 91,
                "rol_id" => $this->getRolId('Jefe'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_PROMEDIO_ENTIDAD->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 92,
                "rol_id" => $this->getRolId('Auxiliar'),
                "permiso_id" => $this->getPermisoId(PermissionEnum::VER_PROMEDIO_ENTIDADES->value),
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                'id' => 93,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::LISTAR_CLASIFICACIONES->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 94,
                'rol_id' => $this->getRolId('Auxiliar'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::LISTAR_CLASIFICACIONES->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 95,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::LISTAR_VISITAS_CAMPOS->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 96,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::DETALLE_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 97,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::CREAR_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 98,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::EDITAR_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 99,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::DETALLE_SEGUIMIENTO_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 100,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::ELIMINAR_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 101,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::LISTAR_SEGUIMIENTOS_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 102,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::GENERAR_REPORTE_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            [
                'id' => 103,
                'rol_id' => $this->getRolId('Jefe'),
                'permiso_id' => $this->getPermisoId(PermissionEnum::GENERAR_REPORTES_VISITA_CAMPO->value),
                'activo' => true,
                'created_at' => Carbon::now()
            ],
            
        ];
        $this->loadInsert($rolPermiso);
    }

    public function loadInsert($rolPermiso)
    {
        try {
            DB::beginTransaction();
            foreach ($rolPermiso as $rp) {
                DB::table('mnt_rol_permisos')->upsert([
                    'id' => $rp['id'],
                    'rol_id' => $rp['rol_id'],
                    'permiso_id' => $rp['permiso_id'],
                    'activo' => $rp['activo'],
                    'created_at' => $rp['created_at'],
                ], 'id');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de Rol/Permisos: " . $e->getMessage());
        }
    }
}
