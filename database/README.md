# Plataforma de Gestión de Tickets e Inventario TI (Help Desk)

Este proyecto es una plataforma web completa de Help Desk e Inventario TI, combinando características de osTicket y GLPI, construida con Laravel 11.

## Requisitos Previos

- **Servidor:** Ubuntu 22.04 LTS / 24.04 LTS (o similar)
- **Servidor Web:** Apache (o Nginx)
- **Base de Datos:** MariaDB (o MySQL 8+)
- **PHP:** 8.2 o superior (con extensiones: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, pdo_mysql, tokenizer, xml)
- **Composer:** Instalado globalmente
- **Node.js & npm:** Para compilar los assets (Tailwind CSS)

## Instalación en Producción (Ubuntu + Apache + MariaDB)

Para instalar el proyecto desde cero en tu servidor, sigue los pasos del script de despliegue `deploy.sh` incluido, o ejecuta los siguientes comandos manualmente:

### Paso 1: Instalar dependencias e iniciar Laravel
1. Navega al directorio donde deseas alojar tu proyecto (ej. `/var/www/html/`)
2. `composer create-project laravel/laravel helpdesk`
3. Copia todos los archivos de este repositorio/directorio, sobreescribiendo los de la instalación base de Laravel.
4. Ejecuta `composer require laravel/breeze --dev` y luego `php artisan breeze:install blade`
5. Instala las dependencias de frontend: `npm install` y compila los assets: `npm run build`

### Paso 2: Configurar el Entorno (.env)
Configura tu archivo `.env` con los datos de tu base de datos MariaDB:
```env
APP_NAME="TI Help Desk"
APP_ENV=production
APP_KEY=base64:xxx
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=helpdesk_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### Paso 3: Migraciones y Seeders
Asegúrate de preparar y poblar la base de datos inicial:
```bash
php artisan migrate --seed
```
Esto creará todos los roles, prioridades, estados y el usuario Admin (admin@admin.com / password).

## Estructura de Roles

* **Admin:** Control total (Usuarios, Estadísticas, Inventario, Todo).
* **Supervisor:** Puede ver todos los tickets, reasignar, ver reportes, pero no modificar configuraciones globales del sistema.
* **Técnico:** Puede ver los tickets asignados, modificar sus estados, responder, añadir notas.
* **Usuario:** Puede crear, responder y ver el estado de sus propios tickets únicamente.

## Directorios y Arquitectura

* **app/Models:** Modelos principales: Ticket, Asset, User, Role, Department, Category, etc.
* **app/Services:** Lógica de negocio (TicketService, AssetService).
* **app/Http/Controllers:** Controladores, divididos entre Portal de Usuarios, Panel Admin y Técnico.
* **database/migrations:** Tablas con relaciones rigurosas.
* **resources/views:** Vistas usando Blade + Tailwind, separadas para Admin y Usuario común.

## Comandos y Utilidades Mantenimiento
- `php artisan optimize:clear`: Limpiar cachés de configuración y vistas.
- `php artisan storage:link`: Enlazar el directorio de almacenamiento público (para adjuntos).
