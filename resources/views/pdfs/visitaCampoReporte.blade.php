<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .logo {
            max-width: 80px;
            margin-top: -70px;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table.table-imgs td {
            border: 1px solid black;
            text-align: center;
        }

        img {
            max-width: 100%;
            max-height: 70%;
        }

        .comentarios {
            text-align: justify;
            margin: 0%;
            padding: 0%;

        }

        ul li p {
            margin: 2px;

        }
    </style>
</head>

<body>
    <h1>Reporte de Franquicia</h1>
    <img src="{{ $logo }}" alt="Logo del gobierno de El Salvador" class="logo">

    <table>
        <tr>
            <td style="text-align: left;">N° de franquicia: {{ $codigoFranquicia }}</td>
            <td style="text-align: right;">Fecha de visita: {{ $fechaVisita }}</td>
        </tr>
    </table>

    <p>Categoría: {{ $categoria }}</p>

    @if ($visitaCampo->nombres->count() > 0)
        <p>Nombre(s) Jurídico/Natural</p>
        <ul>
            @foreach ($nombres as $nombre)
                <li>{{ $nombre }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Detalle del reporte --}}


    <div class="comentarios">
        <p><strong>Comentarios</strong></p>
        {!! $comentarios !!}
    </div>

    {{-- Imágenes adjuntas en reportes --}}

    @if ($visitaCampo->archivos->count() > 0)
        <table class="table-imgs">
            @foreach ($visitaCampo->archivos->chunk(1) as $chunk)
                <tr>
                    @foreach ($chunk as $documento)
                        <td>
                            <img src="{{ storage_path('app/' . $documento->ruta) }}">
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @endif
</body>

</html>
