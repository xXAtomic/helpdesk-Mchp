# Manual Técnico: Despliegue, API REST y Seguridad Cloudflare

Este documento complementa el `README.md` principal enfocado en administradores o DevOps, para llevar la plataforma de una instalación base a un formato **Production-Ready** integrable.

## 1. Integración con Cloudflare

Tu servidor en Ubuntu (Apache + MariaDB) debe colocarse detrás del proxy de Cloudflare para maximizar la seguridad (DDoS protection) y el rendimiento (Caché).

### Pasos en el Dashboard de Cloudflare

1. **Registro de Configuración DNS**:
   Para que todo quede documentado y evitar fallos de conexión posteriores, debes establecer el siguiente registro de DNS en el panel. Reemplaza el valor con tu IP real:

   | Tipo de Registro | Nombre (subdominio) | Objetivo (Valor)                | Proxy status          |
   |------------------|---------------------|---------------------------------|-----------------------|
   | **A**            | `soporte` (o `@`)   | **\[IP PÚBLICA DEL SERVIDOR\]** | 🟠 Proxied (Activado) |

   > **Nota de Seguridad:** Al mantener la "nube naranja" activada, la IP real de tu servidor Ubuntu queda oculta frente a atacantes.

2. **Criptografía (SSL/TLS) - [CRÍTICO]**:
   - Para **evitar el problema de bucle infinito** (`ERR_TOO_MANY_REDIRECTS`) muy común al poner Laravel detrás de Cloudflare:
   - Configura el Modo SSL/TLS de Cloudflare en **Full (Strict)** asumiendo que has instalado un certificado válido en tu Apache (ej. Let's Encrypt).
   - Ve a "Edge Certificates" en Cloudflare y activa **"Siempre usar HTTPS"** (Always Use HTTPS).

3. **Reglas de WAF (Web Application Firewall)**:
   - **Bloqueo a nivel de servidor:** Configura el firewall de tu máquina Ubuntu (UFW) para que SOLO acepte tráfico web (puertos 80 y 443) desde las IPs de Cloudflare (`https://www.cloudflare.com/ips/`), ignorando todas las demás.
   - **Filtros Cloudflare:** Crea un WAF Rule con un "Managed Challenge" para descartar bots que provengan de fuera de tu país de operaciones (ejemplo: Bloquear todo lo que no sea tu país de origen).

### Configuración Laravel para Proxies (Cloudflare)

Al estar detrás de Cloudflare, la IP del cliente real se oculta y Laravel podría detectar las conexiones de CF.
Ve al archivo `bootstrap/app.php` o al middleware global (`app/Http/Middleware/TrustProxies.php`) y pon:

```php
protected $proxies = '*'; // Confiar en todos los proxies si Cloudflare es la única puerta de entrada
```

---

## 2. Documentación API REST (Sanctum)

El sistema ahora está equipado (en la carpeta `routes/api.php` y en `app/Http/Controllers/Api/`) con endpoints REST nativos que te sirven para integrarte en un futuro o automatizar tareas desde otra app C#.

### A) Generar y Utilizar un Token

Para utilizar el API, un usuario (generalmente un técnico o admin) debe ser autenticado vía Laravel Sanctum (incluido en Laravel 11/Breeze). El token irá en la cabecera:
`Authorization: Bearer 1|tu_token_secreto_aqui`

### B) Endpoints Disponibles por Defecto

#### ➔ TICKETS

1. **[GET] `/api/tickets`**
   - Retorna un JSON con la lista paginada de tickets.
   - Ejemplo de respuesta:
     `{"data": [{"ticket_number": "TCK-123", "status": "Abierto"}], "meta": {...}}`
2. **[GET] `/api/tickets/{id}`**
   - Muestra el ticket completo con sus notas de chat e información de técnico.
3. **[POST] `/api/tickets`**
   - Crear un ticket de tercero. Requiere body:
     `{ "title": "...", "description": "...", "category_id": 1, "priority_id": 1 }`

#### ➔ INVENTARIO / ACTIVOS (Assets)

1. **[GET] `/api/assets`**
   - Retorna inventario hardware cargado en la organización.
2. **[POST] `/api/assets`**
   - Importador para añadir activos masivos (Ej: si escaneas un código QR).
     Valores: `asset_tag`, `type` (Notebook, PC, Router), `serial_number`, `user_id`.

#### ➔ USUARIOS

1. **[GET] `/api/users`**
   - Listar usuarios.
2. **[POST] `/api/users`**
   - Crear usuario.

---

## 3. Próximos pasos y Mantenimiento

Para asegurar tu sistema ante subida de archivos (adjuntos en tickets):

- Verifica que PHP cargue archivos hasta 20MB reconfigurando tu `/etc/php/8.x/apache2/php.ini`:
  `upload_max_filesize = 20M`
  `post_max_size = 25M`
- En producción real, puedes mapear los archivos hacia **AWS S3** alterando `FILESYSTEM_DISK=s3` dentro de tu archivo `.env`.
