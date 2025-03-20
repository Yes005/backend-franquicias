<?php

namespace App\Http\Mocks;


class FilterVisitaMock
{

    const ENTIDADES = [
        [

            [
                "institucion_id" => 16,
                "oficial_id" => null,
                "nombre" => "institución prueba",

            ],
        ]
    ];


    const CODIGOS_ENTIDAD = [[
        "message" => "Codigos de franquicias",
        "codigos" => [
            "2024-010-961-104",
            "2024-010-961-110",
            "2024-666-961-114"
        ]
    ]];
    const SEGUIMIENTOS_ENTIDAD = [
        [
            "message" => "Numero de seguimientos de visitas",
            "seguimientos" => [
                "96",
            ]
        ]
    ];
}
