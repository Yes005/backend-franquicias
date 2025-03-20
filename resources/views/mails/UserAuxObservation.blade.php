<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Observaciones de franquicia</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0eded; height: 100vh;">
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-radius: 20px; box-shadow: 10px 10px 50px 0px #00000040; text-align: center;">
                    <tr>
                        <td style="padding-top: 30px; background-color: #ffffff; border-radius: 20px 20px 0 0;">
                            @component('components.header-mail', ['usuario' => $usuario])
                            @endcomponent
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; padding-top:0px; background-color: #ffffff; border-radius: 0 0 20px 20px;">
                            <p style="color: #1c1e4d; font-size: 20px; font-weight: 600;">
                                Se realizaron algunas observaciones en la solicitud de tu franquicia:
                            </p>
                            <p style="color: #1c1e4d; font-size: 20px; font-weight: 600; padding-top: 10px">
                                {{ $codigoProvisional }}
                            </p>
                            <a href="{{ env('BASE_URL_FRONTEND', '') . $url }}"
                                style="font-size: 15px; font-weight: 600; background-color: #1c1e4d; color: #ffff; padding: 8px 40px; text-decoration: none; border-radius: 100px; display: inline-block; margin: 15px;">
                                Ver franquicia
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
