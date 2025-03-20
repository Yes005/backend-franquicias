<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario desbloqueado</title>
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
                        <td style="padding: 30px; padding-top:0px; background-color: #ffffff;">
                            <p style="color: #1c1e4d; font-size: 19px; font-weight: 400;">
                                Se ha restablecido tu credencial
                            </p>
                            <p style="color: #1c1e4d; font-size: 19px; font-weight: 400;">
                                Ingrese con su correo electrónico y la siguiente contraseña temporal:
                                <span
                                    style="color: #1c1e4d; font-size: 19px; font-weight: 700;">{{ $temp_password }}</span>
                            </p>
                            <a href="{{ env('BASE_URL_FRONTEND', '') . $url }}"
                                style="font-size: 15px; font-weight: 600; background-color: #1c1e4d; color: #ffff; padding: 8px 40px; text-decoration: none; border-radius: 100px; display: inline-block; margin: 5px;">
                                Ingresar
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; padding-top:0px;  background-color: #ffffff;border-radius: 0 0 20px 20px;">
                            @component('components.footer-mail', ['url' => $url])
                            @endcomponent
                        </td>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
