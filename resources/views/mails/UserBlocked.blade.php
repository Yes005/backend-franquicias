<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario bloqueado</title>
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
                        <td style="padding: 30px; padding-top:0px; background-color: #ffffff; border-radius: 0 0 20px 20px;">
                            <p style="color: #1c1e4d; font-size: 22px; font-weight: 600;">
                                Tu cuenta ha sido bloqueada temporalmente debido a cinco intentos erróneos de ingreso con tu contraseña
                            </p>
                            <p style="color: #1c1e4d; padding-top: 15px; font-size: 22px; font-weight: 600;">
                                Contacta a la administración para desbloquear tu usuario
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
