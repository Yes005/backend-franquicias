<?php

namespace App\Http\Mocks;


/**
 * Class VisitaCampoMock
 * @package App\Http\Mocks
 * @codeCoverageIgnore
 * Description: Mock de datos de respuestas para documentación
 */
class  VisitaCampoMock
{
    const INDEX = [
        [
            [
                "id" => 20,
                "numero_seguimiento" => "96",
                "correlativo" => 1,
                "fecha_visita" => "2025-06-10T06:00:00.000000Z",
                "codigo_franquicia" => "2024-010-002-96",
                "estado" => [
                    "id" => 8,
                    "nombre" => "Finalizado"
                ],
                "entidad" => [
                    "id" => 33,
                    "nombre" => "Oficial editado"
                ]
            ]
        ]
    ];

    const STORE = [
        [
            "entidad_id" => "14",
            "categoria_visita_id" => "1",
            "detalle" => "<p>HOLA EJEMLO DE <span>hola<\/span>\n<\/p>",
            "fecha_visita" => "2025-06-10T06:00:00.000000Z",
            "estado_id" => 8,
            "numero_seguimiento" => "96",
            "correlativo" => 6,
            "updated_at" => "2025-01-23T15:04:56.000000Z",
            "created_at" => "2025-01-23T15:04:56.000000Z",
            "id" => 40,
            "codigo_franquicia" => "2024-010-001-96"
        ]
    ];

    const UPDATE = [
        [

            "id" => 80,
            "numero_seguimiento" => "96",
            "correlativo" => 1,
            "entidad_id" => "14",
            "fecha_visita" => "2025-06-20",
            "categoria_visita_id" => "1",
            "detalle" => "<p>HOLA EJEMLO DE <span>hola<\/span>\n<\/p>",
            "estado_id" => 1,
            "created_at" => "2025-01-23T20:34:10.000000Z",
            "updated_at" => "2025-01-23T20:34:52.000000Z",
            "codigo_franquicia" => "2024-010-001-96"

        ]
    ];


    const DELETE = [[
        'message' => 'Visita eliminada correctamente'
    ]];

    const DETALLE_VISITA = [

        [
            "id" => 1,
            "fecha_visita" => "2025-01-23",
            "codigo_franquicia" => "2024-SF2-001-9480",
            "estado" => "Aprobada",
            "nombres" => [
                "EJemplo 1"
            ],
            "archivos" => [
                [
                    "id" => 1,
                    "nombre_archivo" => "documento-obs-2.pdf",
                    "base64" => "Tm90aGluZyB0aGF0Lg==",
                    "extension" => "pdf"
                ]
            ],
            "correlativo_file" => 25,
            "file_name" => "ArchivoAdjunto25_1-2024-SF2-001-9480-32"
        ]
    ];


    const SEGUIMIENTO_INDEX = [[
        [
            "id" => 17,
            "entidad_id" => 1,
            "codigo_franquicia" => "2024-SF2-001-9480",
            "numero_seguimiento" => "9480",
            "entidad" => "Institución test"
        ]
    ]];

    const DETALLE_SEGUIMIENTO_VISITA_CAMPO = [
        [
            "numero_seguimiento" => 120,
            "entidad" => "institución prueba",
            "codigo_franquicia" => null,
            "totales" => [
                "total_reportes" => 5,
                "total_con_observaciones" => 2,
                "total_sin_observaciones" => 3
            ],
            "reportes" => [
                [
                    "franquicia" => "institución prueba",
                    "numero_seguimiento" => 120,
                    "fecha_visita" => "2025-01-23",
                    "detalle" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Fusce vestibulum nulla enim, at maximus nunc lobortis sed. Donec eget sollicitudin nulla
                    . Donec pharetra nisl et massa accumsan suscipit. In eleifend at felis ut lobortis.
                    In eget orci eu lacus feugiat convallis ut et lacus. Duis blandit metus et bibendum fermentum.
                    Curabitur nec sem sagittis, convallis nisi non, mollis mauris. Maecenas eu orci sit amet massa
                    consequat mattis. Donec nec dolor vestibulum mauris varius luctus. Duis libero mauris, malesuada eu ex et,
                    consequat finibus ex. Donec porttitor velit sit amet nibh tempor, id cursus tortor condimentum.
                    Suspendisse feugiat orci dui, vel convallis mi mattis eget.",
                    "estado" => "Solventada"
                ],
            ]
        ]
    ];
}
