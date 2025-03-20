<p align="center"><a href="https://presidencia.gob.sv/" target="_blank"><img src="./public/img/secretaria-privada.svg" alt="Logo de Secretaría de Innovación"></a></p>

# Backend Franquicias Presidenciales

## Introducción
Este es un proyecto desarrollado con el framework Laravel. Laravel es un framework PHP moderno y elegante que facilita la creación de aplicaciones web robustas y escalables. Este proyecto incluye una serie de características y funcionalidades preconfiguradas para acelerar el desarrollo.

El fin del proyecto es gestionar usuarios, los permisos y roles de los mismos; además, el mantenimiento de oficiales, instituciones, facturas, aduanas, firmas, clases e identificadores de gestión. Tambien permite gestionar cada una de las franquicias según el tipo de rol, y permite la creación de reportes y calificación de las franquicias por entidad.

## Tabla de Contenidos
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
  - [Base de datos](#base-de-datos)
  - [Job](#job)
  - [Redis](#redis)
  - [Correos](#correos)

# Requisitos
Antes de comenzar, asegúrate de tener lo siguiente instalado en tu entorno:

- [![Static Badge](https://img.shields.io/badge/version%20%3E%3D%202.4-a?logo=composer&label=Composer&color=green)](https://getcomposer.org/download/)

- [![Static Badge](https://img.shields.io/badge/version%20%3E%3D%208.1-a?logo=php&label=PHP&labelColor=grey&color=green)](https://www.php.net/downloads.php)

- [![Static Badge](https://img.shields.io/badge/version%20%3E%3D%208.0-a?logo=mysql&labelColor=grey&label=MySQL&color=green)](https://dev.mysql.com/downloads/mysql/)


# Instalación
Sigue estos pasos para instalar el proyecto en tu entorno local:
1. Clona este repositorio:
    ```bash
    git clone http://gitlab.egob.sv/avargas90/franquicias-presidenciales-backend.git
    ```
2. Instala las dependencias de PHP utilizando Composer:
    ```bash
    composer install
    ```
3. Copia el archivo `.env.example` a `.env` y configura tus variables de entorno:
    ```bash
    cp .env.example .env
    ```
4. Inicia el servidor local de Laravel:
    ```bash
    php artisan serve
    ```
    Ahora puedes acceder en http://localhost:8000.


## Configuración
### Base de datos
Para configurar la base de datos, asegúrate de que los detalles en tu archivo `.env` correspondan a los de tu entorno. El proyecto está configurado para usar MySQL.

Asegúrate de que MySQL esté instalado y ejecutándose.
Configura las siguientes variables en el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=franquicias_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contrasenia
```
A continuación, se explica cada una de las variables de configuración:

- `DB_CONNECTION=mysql`: Define el tipo de base de datos que estás utilizando. En este caso, el proyecto está configurado para usar MySQL.

- `DB_HOST=127.0.0.1`: Esta variable define la dirección del host donde se encuentra la base de datos. `127.0.0.1` es la dirección IP de localhost, lo que significa que la base de datos está alojada en la misma máquina donde se está ejecutando la aplicación.

    >💡 En un servidor de producción, debes reemplazarlo con la IP o el nombre de dominio que apunte al servidor donde está alojada la base de datos.

- `DB_PORT=3306`: Especifica el puerto en el que se conecta la base de datos. `3306` es el puerto predeterminado para MySQL.

    >💡 Si tu base de datos está configurada en otro puerto, asegúrate de actualizar este valor.

- `DB_DATABASE=franquicias_db`: El nombre de la base de datos que se utilizará en este proyecto.

    >💡 Cambia este nombre según tu configuración local o el nombre de la base de datos en el servidor de producción.

- `DB_USERNAME=tu_usuario`: Esta variable especifica el nombre de usuario que se utilizará para conectarse a la base de datos. root es el nombre de usuario predeterminado para el administrador en MySQL, si utiliza otro debe cambiarlo.

    >💡 Cambia el nombre de usuario si tu usuario es diferente.

- `DB_PASSWORD=tu_contrasenia`: La contraseña asociada con el nombre de usuario.

    >💡En producción, usa un nombre de usuario y una contraseña más seguros.

### Job
El sistema de jobs está configurado para usar Redis, lo que permite gestionar tareas en segundo plano de forma eficiente. A continuación, la configuración básica:

- `QUEUE_CONNECTION=redis`: Define que las colas de trabajos utilizarán **Redis** como motor.

Después de configurar las colas, asegúrate de ejecutar el siguiente comando para iniciar el procesamiento de trabajos:

```bash
php artisan queue:work
```
### Redis
Redis se utiliza tanto para caché como para gestionar las colas de trabajos. Configura las siguientes variables en el archivo `.env`:

- `REDIS_HOST=127.0.0.1`: Define la dirección del host donde está corriendo Redis. En local, esto será `127.0.0.1`.

    >💡 En un servidor, cambia este valor para apuntar al servidor donde Redis está alojado.

- `REDIS_PASSWORD=null`: Si tu instancia de Redis requiere autenticación, coloca aquí la contraseña. De lo contrario, deja este valor en `null`.

- `REDIS_PORT=6379`: Especifica el puerto de Redis, que generalmente es `6379` por defecto.

### Correos
Para la configuración de correos, este proyecto soporta tanto un servidor SMTP de pruebas (como Mailtrap) como configuraciones para servidores de correo reales (como Gmail).

- `MAIL_MAILER=smtp`: Define que los correos se enviarán a través del protocolo SMTP.

- `MAIL_HOST=smtp.gmail.com`: El servidor SMTP que se utilizará. _Para pruebas locales, puedes usar servicios como Mailtrap_.

    > 💡 Cambia este valor por el servidor SMTP de tu proveedor de correos en producción.

- `MAIL_PORT=587`: El puerto utilizado por el servidor SMTP.

- `MAIL_USERNAME="pruebracorreos@gmail.com"`: El nombre de usuario de la cuenta de correo que enviará los emails, por ejemplo puede ser `MAIL_USERNAME="Secretaria Privada de la Presidencia"`.

- `MAIL_PASSWORD=clave_generada_en_SMTP`: La contraseña generada para esa cuenta (Esta contraseña la genera el servidor SMTP).

- `MAIL_ENCRYPTION=tls`: Define el protocolo de cifrado que se usará. `tls` es recomendado para conexiones seguras.

- `MAIL_FROM_ADDRESS=secretaria@privada.gob.sv`: Dirección de correo que aparecerá como remitente.

- `MAIL_FROM_NAME="Secretaría Privada de la Presidencia"`: El nombre que aparecerá como remitente en los correos.

  >💡 Asegúrate de configurar estos valores correctamente para que los correos sean enviados desde la dirección y con el nombre correctos en producción.
