#!/bin/bash

echo "🚀 Iniciando instalación de Plataforma Help Desk TI..."

# 1. Actualizar sistema e instalar pre-requisitos
sudo apt update && sudo apt upgrade -y
sudo apt install -y software-properties-common curl zip unzip git php-cli php-mbstring php-xml php-bcmath php-mysql poppler-utils npm apache2 mariadb-server

# 2. Instalar Composer (si no está instalado)
if ! command -v composer &> /dev/null
then
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
fi

# 3. Configurar MariaDB (Crea BD y usuario local)
# Atención: Esto es un ejemplo, configurar contraseñas seguras en producción
sudo mysql -e "CREATE DATABASE IF NOT EXISTS helpdesk_db;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'admin_helpdesk'@'localhost' IDENTIFIED BY 'Password123!';"
sudo mysql -e "GRANT ALL PRIVILEGES ON helpdesk_db.* TO 'admin_helpdesk'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# 4. Copiar código a la ruta de apache (Asumimos que el código está en /var/www/helpdesk)
# Asegúrate de haber copiado el proyecto antes de este paso a /var/www/helpdesk
sudo chown -R www-data:www-data /var/www/helpdesk
sudo chmod -R 775 /var/www/helpdesk/storage
sudo chmod -R 775 /var/www/helpdesk/bootstrap/cache

# 5. Instalar dependencias PHP y JS
cd /var/www/helpdesk
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 6. Configurar el archivo .env (Deberías haberlo creado previamente)
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# 7. Ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

# 8. Configurar Virtual Host de Apache
sudo bash -c 'cat > /etc/apache2/sites-available/helpdesk.conf <<EOF
<VirtualHost *:80>
    ServerName ticket.crisadones.com
    DocumentRoot /var/www/helpdesk/public

    <Directory /var/www/helpdesk/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/helpdesk_error.log
    CustomLog \${APACHE_LOG_DIR}/helpdesk_access.log combined
</VirtualHost>
EOF'

sudo a2enmod rewrite
sudo a2ensite helpdesk.conf
sudo systemctl restart apache2

echo "✅ Despliegue completado con éxito."
echo "Puedes acceder a tu sistema web y usar 'admin@admin.com' con contraseña 'password' para ingresar."
