<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Enum\TagsEnum;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            [
                "id" => 1,
                "nombre" => PermissionEnum::RUTA_RECUPERAR_CONTRASENIA->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta recuperar contraseña",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "nombre" => PermissionEnum::RUTA_CONFIGURACIONES->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta configuraciones",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "nombre" => PermissionEnum::RUTA_ADUANA->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta aduanas",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 4,
                "nombre" => PermissionEnum::RUTA_FACTURA->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta tipos de franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 5,
                "nombre" => PermissionEnum::LISTAR_ADUANA->value,
                "activo" => true,
                "tag" => TagsEnum::ADUANAS->value,
                "descripcion" => "Listar aduanas",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 6,
                "nombre" => PermissionEnum::CREAR_ADUANA->value,
                "activo" => true,
                "tag" => TagsEnum::ADUANAS->value,
                "descripcion" => "Crear aduana",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 7,
                "nombre" => PermissionEnum::ACTUALIZAR_ADUANA->value,
                "activo" => true,
                "tag" => TagsEnum::ADUANAS->value,
                "descripcion" => "Actualizar aduana",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 8,
                "nombre" => PermissionEnum::LISTAR_FACTURAS->value,
                "activo" => true,
                "tag" => TagsEnum::FACTURAS->value,
                "descripcion" => "Listar tipos de franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 9,
                "nombre" => PermissionEnum::CREAR_FACTURA->value,
                "tag" => TagsEnum::FACTURAS->value,
                "activo" => true,
                "descripcion" => "Crear tipo de franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 10,
                "nombre" => PermissionEnum::ACTUALIZAR_FACTURA->value,
                "activo" => true,
                "tag" => TagsEnum::FACTURAS->value,
                "descripcion" => "Actualizar tipo de franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 11,
                "nombre" => PermissionEnum::RUTA_INSTITUCIONES->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta instituciones",
                "created_at" => Carbon::now()
            ],

            [
                "id" => 12,
                "nombre" => PermissionEnum::RUTA_OFICIAL->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta oficiales",
                "created_at" => Carbon::now()
            ],

            [
                "id" => 13,
                "nombre" => PermissionEnum::RUTA_CLASE->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta clases",
                "created_at" => Carbon::now()
            ],

            [
                "id" => 14,
                "nombre" => PermissionEnum::RUTA_IDENTIFICADOR_GESTION->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta identificadores gestión",
                "created_at" => Carbon::now()
            ],

            [
                "id" => 15,
                "nombre" => PermissionEnum::RUTA_FRANQUICIA->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta franquicias",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 16,
                "nombre" => PermissionEnum::LISTAR_CLASES->value,
                "activo" => true,
                "tag" => TagsEnum::CLASES->value,
                "descripcion" => "Listar clases",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 17,
                "nombre" => PermissionEnum::CREAR_CLASE->value,
                "activo" => true,
                "tag" => TagsEnum::CLASES->value,
                "descripcion" => "Crear clase",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 18,
                "nombre" => PermissionEnum::ACTUALIZAR_CLASE->value,
                "activo" => true,
                "tag" => TagsEnum::CLASES->value,
                "descripcion" => "Actualizar clase",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 19,
                "nombre" => PermissionEnum::LISTAR_OFICIALES->value,
                "activo" => true,
                "tag" => TagsEnum::OFICIALES->value,
                "descripcion" => "Listar oficiales",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 20,
                "nombre" => PermissionEnum::CREAR_OFICIAL->value,
                "activo" => true,
                "tag" => TagsEnum::OFICIALES->value,
                "descripcion" => "Crear oficial",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 21,
                "nombre" => PermissionEnum::ACTUALIZAR_OFICIAL->value,
                "activo" => true,
                "tag" => TagsEnum::OFICIALES->value,
                "descripcion" => "Actualizar oficial",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 22,
                "nombre" => PermissionEnum::LISTAR_INSTITUCIONES->value,
                "activo" => true,
                "tag" => TagsEnum::INSTITUCIONES->value,
                "descripcion" => "Listar instituciones",
                "created_at" => Carbon::now()

            ],
            [
                "id" => 23,
                "nombre" => PermissionEnum::CREAR_INSTITUCION->value,
                "activo" => true,
                "tag" => TagsEnum::INSTITUCIONES->value,
                "descripcion" => "Crear institución",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 24,
                "nombre" => PermissionEnum::ACTUALIZAR_INSTITUCION->value,
                "activo" => true,
                "tag" => TagsEnum::INSTITUCIONES->value,
                "descripcion" => "Actualizar institución",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 25,
                "nombre" => PermissionEnum::LISTAR_IDENTIFICADOR_GESTION->value,
                "activo" => true,
                "tag" => TagsEnum::IDENTIFICADOR_GESTION->value,
                "descripcion" => "Listar identificador gestión",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 26,
                "nombre" => PermissionEnum::CREAR_IDENTIFICADOR_GESTION->value,
                "activo" => true,
                "tag" => TagsEnum::IDENTIFICADOR_GESTION->value,
                "descripcion" => "Crear identificador gestión",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 27,
                "nombre" => PermissionEnum::ACTUALIZAR_IDENTIFICADOR_GESTION->value,
                "activo" => true,
                "tag" => TagsEnum::IDENTIFICADOR_GESTION->value,
                "descripcion" => "Actualizar identificador gestión",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 28,
                "nombre" => PermissionEnum::RUTA_FIRMA->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta firma",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 29,
                "nombre" => PermissionEnum::LISTAR_FIRMANTES->value,
                "activo" => true,
                "tag" => TagsEnum::FIRMANTE->value,
                "descripcion" => "Listar firmantes",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 30,
                "nombre" => PermissionEnum::CREAR_FIRMANTE->value,
                "activo" => true,
                "tag" => TagsEnum::FIRMANTE->value,
                "descripcion" => "Crear firmante",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 31,
                "nombre" => PermissionEnum::ACTUALIZAR_FIRMANTE->value,
                "activo" => true,
                "tag" => TagsEnum::FIRMANTE->value,
                "descripcion" => "Actualizar firmante",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 32,
                "nombre" => PermissionEnum::RUTA_USUARIOS->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta usuarios",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 33,
                "nombre" => PermissionEnum::LISTAR_USERS->value,
                "activo" => true,
                "tag" => TagsEnum::USUARIOS->value,
                "descripcion" => "Listar usuarios",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 34,
                "nombre" => PermissionEnum::CREAR_USER->value,
                "activo" => true,
                "tag" => TagsEnum::USUARIOS->value,
                "descripcion" => "Crear usuario",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 35,
                "nombre" => PermissionEnum::ACTUALIZAR_USER->value,
                "activo" => true,
                "tag" => TagsEnum::USUARIOS->value,
                "descripcion" => "Actualizar usuario",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 36,
                "nombre" => PermissionEnum::DESBLOQUEAR_USER->value,
                "activo" => true,
                "tag" => TagsEnum::USUARIOS->value,
                "descripcion" => "Desbloquear usuario",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 37,
                "nombre" => PermissionEnum::CREAR_FRANQUICIA->value,
                "activo" => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Crear franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 38,
                "nombre" => PermissionEnum::ACTUALIZAR_FRANQUICIA->value,
                "activo" => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Actualizar franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 39,
                "nombre" => PermissionEnum::VER_DETALLE_FRANQUICIA->value,
                "activo" => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Ver detalle franquicia",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 40,
                "nombre" => PermissionEnum::RUTA_PERMISOS->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta Permisos",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 41,
                "nombre" => PermissionEnum::RUTA_ROLES->value,
                "activo" => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta roles",
                "created_at" => Carbon::now()
            ],

            [
                "id" => 42,
                "nombre" => PermissionEnum::CREAR_ROL->value,
                "activo" => true,
                "tag" => TagsEnum::ROLES->value,
                "descripcion" => "Crear rol",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 43,
                "nombre" => PermissionEnum::ACTUALIZAR_ROL->value,
                "activo" => true,
                "tag" => TagsEnum::ROLES->value,
                "descripcion" => "Actualizar rol",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 44,
                "nombre" => PermissionEnum::LISTAR_ROLES->value,
                "activo" => true,
                "tag" => TagsEnum::ROLES->value,
                "descripcion" => "Listar roles",
                "created_at" => Carbon::now()
            ],
            [
                "id" => 45,
                "nombre" => PermissionEnum::LISTAR_PERMISOS->value,
                "activo" => true,
                "tag" => TagsEnum::PERMISOS->value,
                "descripcion" => "Listar permisos",
                "created_at" => Carbon::now()
            ],

            [
                'id' => 46,
                'nombre' => PermissionEnum::RUTA_USUARIOS_ROLES->value,
                'activo' => true,
                "tag" => TagsEnum::RUTAS->value,
                "descripcion" => "Ruta usuarios roles",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 47,
                "nombre" => PermissionEnum::LISTAR_FRANQUICIAS->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Listar franquicias",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 48,
                "nombre" => PermissionEnum::CREAR_BORRADOR->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Crear borrador",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 49,
                "nombre" => PermissionEnum::OBSERVAR_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Observar franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 50,
                "nombre" => PermissionEnum::ENVIAR_FRANQUICIA_REVISION->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Enviar franquicia revisión",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 51,
                "nombre" => PermissionEnum::SOLVENTAR_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Solventar fraquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 52,
                "nombre" => PermissionEnum::RUTA_REPORTES->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Ruta reportes",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 53,
                "nombre" => PermissionEnum::SUBIR_ARCHIVOS_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Subir archivos franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 54,
                "nombre" => PermissionEnum::VER_ARCHIVOS_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Ver archivos franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 55,
                "nombre" => PermissionEnum::LISTAR_ARCHIVOS_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Listar archivos franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 56,
                "nombre" => PermissionEnum::ELIMINAR_ARCHIVOS_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Eliminar archivos franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 57,
                "nombre" => PermissionEnum::ANULAR_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Anular franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 58,
                "nombre" => PermissionEnum::APROBAR_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Aprobar franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 59,
                "nombre" => PermissionEnum::PREVISUALIZAR_DOCUMENTO_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Previsualizar documento franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 60,
                "nombre" => PermissionEnum::ACTUALIZAR_OBSERVACION_FRANQUICIA->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Actualizar observación franquicia",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 61,
                "nombre" => PermissionEnum::GESTIONAR_FECHAS->value,
                'activo' => true,
                "tag" => TagsEnum::FRANQUICIAS->value,
                "descripcion" => "Gestionar fechas",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 62,
                'nombre' => PermissionEnum::GENERAR_REPORTES->value,
                'activo' => true,
                "tag" => TagsEnum::REPORTES->value,
                "descripcion" => "Generar reportes",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 63,
                'nombre' => PermissionEnum::PUNTUAR_FRANQUICIAS->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Puntuar franquicias",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 64,
                'nombre' => PermissionEnum::VER_PUNTAJE_FRANQUICIAS->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Ver puntaje franquicias",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 65,
                'nombre' => PermissionEnum::GUARDAR_OBSERVACION->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Guardar observación",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 66,
                'nombre' => PermissionEnum::LISTAR_OBSERVACIONES->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Listar observaciones",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 67,
                'nombre' => PermissionEnum::PREVISUALIZAR_ARCHIVO_OBSERVACION->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Ver archivo observación",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 68,
                'nombre' => PermissionEnum::ELIMINAR_OBSERVACION->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Eliminar observación",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 69,
                'nombre' => PermissionEnum::VER_PROMEDIO_ENTIDAD->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Ver promedio entidad",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 70,
                'nombre' => PermissionEnum::VER_PROMEDIO_ENTIDADES->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Ver promedio entidades",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 71,
                'nombre' => PermissionEnum::LISTAR_CLASIFICACIONES->value,
                'activo' => true,
                "tag" => TagsEnum::CLASIFICACION->value,
                "descripcion" => "Listar clasificaciones",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 72,
                'nombre' => PermissionEnum::LISTAR_VISITAS_CAMPOS->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Listar visitas de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 73,
                'nombre' => PermissionEnum::DETALLE_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Detalle visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 74,
                'nombre' => PermissionEnum::CREAR_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Crear visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 75,
                'nombre' => PermissionEnum::EDITAR_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Editar visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 76,
                'nombre' => PermissionEnum::DETALLE_SEGUIMIENTO_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Detalle seguimiento visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 77,
                'nombre' => PermissionEnum::ELIMINAR_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Eliminar visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 78,
                'nombre' => PermissionEnum::LISTAR_SEGUIMIENTOS_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Listar seguimientos visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 79,
                'nombre' => PermissionEnum::GENERAR_REPORTE_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Generar reporte de visita de campo",
                'created_at' => Carbon::now()
            ],
            [
                'id' => 80,
                'nombre' => PermissionEnum::GENERAR_REPORTES_VISITA_CAMPO->value,
                'activo' => true,
                "tag" => TagsEnum::VISITAS_CAMPO->value,
                "descripcion" => "Generar reportes de visita de campo por franquicia",
                'created_at' => Carbon::now()
            ],

        ];

        $this->loadInsert($permisos);
    }

    public function loadInsert($permisos)
    {
        try {
            DB::beginTransaction();
            foreach ($permisos as $permiso) {
                DB::table('ctl_permisos')->upsert([
                    'id' => $permiso['id'],
                    'nombre' => $permiso['nombre'],
                    'activo' => $permiso['activo'],
                    'descripcion' => $permiso['descripcion'],
                    'tag' => $permiso['tag'],
                    'created_at' => $permiso['created_at'],
                ], 'id');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de permisos: " . $e->getMessage());
        }
    }
}
