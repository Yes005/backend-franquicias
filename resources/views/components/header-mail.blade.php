<div>
    <div style="padding: 10px 20px 0px 20px">
        @if (env('APP_ENV') === 'local')
            <img src="https://i.ibb.co/n0zW3Lr/secretaria-privada.png" alt="Secretaría Privada"
                style="width: 100%; max-width: 350px;">
        @else
            <img src="{{ asset('img/secretaria-privada.png') }}" alt="Secretaría Privada"
                style="width: 100%; max-width: 350px">
        @endif
    </div>
    <h1 style="color: #1c1e4d; font-weight: 600; font-size: 30px; margin: 70px 0 30px; padding:5px">¡Hola:
        {{ $usuario['nombreUsuario'] }}{{ $usuario['apellidoUsuario'] != '' ? ' ' . $usuario['apellidoUsuario'] : null }}!
    </h1>
</div>
