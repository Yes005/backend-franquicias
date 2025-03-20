<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enum\PermissionEnum;
use App\Helpers\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private static function getPermisoId($name)
    {
        return DB::table('ctl_permisos')->where('nombre', $name)->first()->id ?? null;
    }

    private function getByNameUri($name)
    {
        return DB::table('mnt_rutas')->where('nombreUri', $name)->first()->id;
    }

    public function run(): void
    {
        try {
            DB::beginTransaction();

            $menu = [
                [
                    'id' => 1,
                    'nombre' => 'Configuraciones',
                    'uri' => '',
                    'nombreUri' => 'configuraciones',
                    'icono' => 'mdi-cog-outline',
                    'orden' => 4,
                    'ruta_padre_id' => null,
                    'mostrar' => true,
                ],
                [
                    'id' => 2,
                    'nombre' => 'Instituciones',
                    'uri' => '/list-instituciones',
                    'nombreUri' => 'listInstituciones',
                    'icono' => '',
                    'orden' => 1,
                    'ruta_padre_id' => 1,
                    'mostrar' => true
                ],
                [
                    'id' => 3,
                    'nombre' => 'Aduanas',
                    'uri' => '/list-aduanas',
                    'nombreUri' => 'listAduanas',
                    'icono' => '',
                    'orden' => 3,
                    'ruta_padre_id' => 1,
                    'mostrar' => true,
                ],
                [
                    'id' => 4,
                    'nombre' => 'Tipo de franquicia',
                    'uri' => '/list-tipo-franquicias',
                    'nombreUri' => 'listFacturas',
                    'icono' => '',
                    'orden' => 4,
                    'ruta_padre_id' => 1,
                    'mostrar' => true,
                ],
                [
                    'id' => 5,
                    'nombre' => 'Oficiales',
                    'uri' => '/list-oficiales',
                    'nombreUri' => 'listOficiales',
                    'icono' => '',
                    'orden' => 2,
                    'ruta_padre_id' => 1,
                    'mostrar' => true
                ],
                [
                    'id' => 6,
                    'nombre' => 'Clases',
                    'uri' => '/list-clases',
                    'nombreUri' => 'listClases',
                    'icono' => '',
                    'orden' => 5,
                    'ruta_padre_id' => 1,
                    'mostrar' => true
                ],
                [
                    'id' => 7,
                    'nombre' => 'Identificadores de gestión',
                    'uri' => '/list-identificadores-gestion',
                    'nombreUri' => 'listIdentificadoresGestion',
                    'icono' => '',
                    'orden' => 6,
                    'ruta_padre_id' => 1,
                    'mostrar' => true
                ],
                [
                    'id' => 8,
                    'nombre' => 'Recuperar Contraseña',
                    'uri' => '/recuperar-password',
                    'nombreUri' => 'recuperarPassword',
                    'icono' => '',
                    'orden' => 1,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],
                [
                    'id' => 9,
                    'nombre' => 'Franquicias',
                    'uri' => '/list-franquicias',
                    'nombreUri' => 'listFranquicias',
                    'icono' => 'mdi-book-outline',
                    'orden' => 1,
                    'ruta_padre_id' => null,
                    'mostrar' => true
                ],
                [
                    'id' => 10,
                    'nombre' => 'Firmas',
                    'uri' => '/list-firmas',
                    'nombreUri' => 'listFirmas',
                    'icono' => 'mdi-square-edit-outline',
                    'orden' => 3,
                    'ruta_padre_id' => null,
                    'mostrar' => true
                ],
                [
                    'id' => 11,
                    'nombre' => 'Crear franquicia',
                    'uri' => '/crear-franquicia',
                    'nombreUri' => 'crearFranquicia',
                    'icono' => 'mdi-square-edit-outline',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],
                [
                    'id' => 12,
                    'nombre' => 'Editar franquicia',
                    'uri' => '/editar-franquicia/:id',
                    'nombreUri' => 'editarFranquicia',
                    'icono' => 'mdi-square-edit-outline',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],
                [
                    'id' => 13,
                    'nombre' => 'Ver franquicia',
                    'uri' => '/ver-franquicia/:id',
                    'nombreUri' => 'verFranquicia',
                    'icono' => 'mdi-square-edit-outline',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],
                [
                    'id' => 14,
                    'nombre' => 'Usuarios y roles',
                    'uri' => '',
                    'nombreUri' => 'usuariosRoles',
                    'icono' => 'mdi-account-cog-outline',
                    'orden' => 5,
                    'ruta_padre_id' => null,
                    'mostrar' => true
                ],
                [
                    'id' => 15,
                    'nombre' => 'Gestión de usuarios',
                    'uri' => '/list-usuarios',
                    'nombreUri' => 'listUsuarios',
                    'icono' => '',
                    'orden' => 1,
                    'ruta_padre_id' => 14,
                    'mostrar' => true
                ],
                [
                    'id' => 16,
                    'nombre' => 'Reportes',
                    'uri' => '/reportes',
                    'nombreUri' => 'reportes',
                    'icono' => 'mdi-file-document-outline',
                    'orden' => 2,
                    'ruta_padre_id' => null,
                    'mostrar' => true
                ],
                [
                    'id' => 17,
                    'nombre' => 'Gestión de roles',
                    'uri' => '/list-roles',
                    'nombreUri' => 'listRoles',
                    'icono' => '',
                    'orden' => 2,
                    'ruta_padre_id' => 14,
                    'mostrar' => true
                ],
                [
                    'id' => 18,
                    'nombre' => 'Agregar rol',
                    'uri' => '/agregar-rol',
                    'nombreUri' => 'agregarRol',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],
                [
                    'id' => 19,
                    'nombre' => 'Editar rol',
                    'uri' => '/editar-rol/:id',
                    'nombreUri' => 'editarRol',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],

                [
                    'id' => 20,
                    'nombre' => 'Visitas de campo',
                    'uri' => '/visitas-campo',
                    'nombreUri' => 'visitasCampo',
                    'icono' => 'mdi-book-open-page-variant-outline',
                    'orden' => 11,
                    'ruta_padre_id' => null,
                    'mostrar' => true
                ],

                [
                    'id' => 21,
                    'nombre' => 'Detalle de seguimiento visita',
                    'uri' => '/detalle-seguimiento/:id',
                    'nombreUri' => 'detalleSeguimiento',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],

                [
                    'id' => 22,
                    'nombre' => 'Crear visita',
                    'uri' => '/crear-visita-campo',
                    'nombreUri' => 'crearVisitaCampo',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],

                [
                    'id' => 23,
                    'nombre' => 'Editar visita',
                    'uri' => '/editar-visita-campo/:id',
                    'nombreUri' => 'editarVisitaCampo',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ],

                [
                    'id' => 24,
                    'nombre' => 'Detalle de visita',
                    'uri' => '/detalle-visita-campo/:id',
                    'nombreUri' => 'detalleVisitaCampo',
                    'icono' => '',
                    'orden' => null,
                    'ruta_padre_id' => null,
                    'mostrar' => false
                ]
            ];

            DB::table('mnt_rutas')->upsert($menu, ['id']);

            $rutasPermiso = [
                [
                    'id' => 1,
                    'ruta_id' => $this->getByNameUri('recuperarPassword'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_RECUPERAR_CONTRASENIA->value),

                ],
                [
                    'id' => 2,
                    'ruta_id' => $this->getByNameUri('configuraciones'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_CONFIGURACIONES->value),
                ],
                [
                    'id' => 3,
                    'ruta_id' => $this->getByNameUri('listAduanas'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_ADUANA->value),
                ],
                [
                    'id' => 4,
                    'ruta_id' => $this->getByNameUri('listFacturas'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FACTURA->value),
                ],
                [
                    'id' => 5,
                    'ruta_id' => $this->getByNameUri('listOficiales'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_OFICIAL->value),
                ],
                [
                    'id' => 6,
                    'ruta_id' => $this->getByNameUri('listClases'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_CLASE->value),
                ],
                [
                    'id' => 7,
                    'ruta_id' => $this->getByNameUri('listIdentificadoresGestion'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_IDENTIFICADOR_GESTION->value),
                ],
                [
                    'id' => 8,
                    'ruta_id' => $this->getByNameUri('listInstituciones'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_INSTITUCIONES->value),
                ],
                [
                    'id' => 9,
                    'ruta_id' => $this->getByNameUri('listFranquicias'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FRANQUICIA->value),
                ],
                [
                    'id' => 10,
                    'ruta_id' => $this->getByNameUri('listFirmas'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_FIRMA->value),
                ],
                [
                    'id' => 11,
                    'ruta_id' => $this->getByNameUri('crearFranquicia'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_FRANQUICIA->value),
                ],
                [
                    'id' => 12,
                    'ruta_id' => $this->getByNameUri('editarFranquicia'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_FRANQUICIA->value),
                ],
                [
                    'id' => 13,
                    'ruta_id' => $this->getByNameUri('verFranquicia'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::VER_DETALLE_FRANQUICIA->value),
                ],
                [
                    'id' => 14,
                    'ruta_id' => $this->getByNameUri('usuariosRoles'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_USUARIOS_ROLES->value),
                ],
                [
                    'id' => 15,
                    'ruta_id' => $this->getByNameUri('listUsuarios'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_USUARIOS->value),
                ],
                [
                    'id' => 16,
                    'ruta_id' => $this->getByNameUri('reportes'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_REPORTES->value),
                ],
                [
                    'id' => 17,
                    'ruta_id' => $this->getByNameUri('listRoles'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::RUTA_ROLES->value),
                ],
                [
                    'id' => 18,
                    'ruta_id' => $this->getByNameUri('agregarRol'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::CREAR_ROL->value),
                ],
                [
                    'id' => 19,
                    'ruta_id' => $this->getByNameUri('editarRol'),
                    "permiso_id" => $this->getPermisoId(PermissionEnum::ACTUALIZAR_ROL->value),
                ],

                [
                    'id' => 20,
                    'ruta_id' => $this->getByNameUri('visitasCampo'),
                    'permiso_id' => $this->getPermisoId(PermissionEnum::LISTAR_VISITAS_CAMPOS->value),
                ],

                [
                    'id' => 21,
                    'ruta_id' => $this->getByNameUri('detalleSeguimiento'),
                    'permiso_id' => $this->getPermisoId(PermissionEnum::DETALLE_SEGUIMIENTO_VISITA_CAMPO->value),
                ],

                [
                    'id' => 22,
                    'ruta_id' => $this->getByNameUri('crearVisitaCampo'),
                    'permiso_id' => $this->getPermisoId(PermissionEnum::CREAR_VISITA_CAMPO->value),

                ],

                [
                    'id' => 23,
                    'ruta_id' => $this->getByNameUri('editarVisitaCampo'),
                    'permiso_id' => $this->getPermisoId(PermissionEnum::EDITAR_VISITA_CAMPO->value),

                ],

                [
                    'id' => 24,
                    'ruta_id' => $this->getByNameUri('detalleVisitaCampo'),
                    'permiso_id' => $this->getPermisoId(PermissionEnum::DETALLE_VISITA_CAMPO->value),
                ]


            ];

            DB::table('mnt_rutas_permiso')->upsert($rutasPermiso, ['id']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de MenuSeeder: " . $e->getMessage());
        }
    }
}
