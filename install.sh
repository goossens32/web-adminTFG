#!/bin/bash
clear
# WEBADMIN INSTALLER, reccomended UPDATE and UPGRADE before execution of script!

# Get user home
USER_HOME=$(eval echo ~${SUDO_USER})

# Get services
get_utils() {

    if [ ! -d /etc/apache2 ]; then
        echo "Apache no está instalado ..."
        echo ""
        sudo apt install apache2 -y
    else
        echo "Apache está instalado"
    fi;

    if [ ! -d /etc/mysql ]; then
        echo "MySQL no está instalado ..."
        echo ""
        sudo apt install mysql-server -y
    else
        echo "MySQL está instalado"
    fi;

    if [ ! -d /etc/php ]; then
        echo "PHP no está instalado"
        echo ""
        sudo apt install php -y
    else
        echo "PHP está instalado"
    fi;

}

config_webpage() {
    sudo apt install composer -y
    if [ ! -d /var/www/web-admin ]; then
        sudo mkdir -v /var/www/web-admin
    fi;
    sudo cp -r public/ /var/www/web-admin/
    sudo cp -r src/ /var/www/web-admin/
    sudo cp -r composer* /var/www/web-admin/
    sudo mkdir -v /var/www/web-admin/sessions
    sudo chown -R www-data:www-data /var/www/web-admin/sessions

    # Install composer dependencies
    cd /var/www/web-admin
    composer install
    cd ${USER_HOME}/web-adminTFG
}


config_apache() {
    echo "Configurando Apache ..."
    sudo cp -v ./installer/webadmin.conf /etc/apache2/sites-available/
    # Creating certs
    if [ ! -f /etc/ssl/private/webadmin-self.key ] && [ ! -f /etc/ssl/certs/webadmin-self.crt ]; then
        echo "Generando clave privada ..."
        # Private cert
        sudo openssl genpkey -algorithm RSA -out /etc/ssl/private/webadmin-self.key -aes256
        echo ""
        echo "Firmando certificado ..."
        sudo openssl req -new -key /etc/ssl/private/webadmin-self.key -out /etc/ssl/certs/webadmin-self.csr -subj "/C=ES/ST=Madrid/L=Madrid/O=webadmin.io/CN=webadmin.io"
        sudo openssl x509 -req -days 365 -in /etc/ssl/certs/webadmin-self.csr -signkey /etc/ssl/private/webadmin-self.key -out /etc/ssl/certs/webadmin-self.crt
        echo ""
    fi;

    # Ennabling needed apache mods and sites
    sudo a2enmod ssl
    sudo a2enmod php8.1
    sudo a2enmod rewrite
    # Restart Apache
    sudo systemctl restart apache2.service
}

config_mysql() {
    # Install mysql php extension
    echo ""
    echo "Configurando MySQL ..."
    echo ""
    echo "Instalando extensión de PHP - MySQL"
    echo ""
    sudo apt install php-mysql -y
    
    # Create MySQL user and database
    sudo mysql <<EOF
CREATE USER IF NOT EXISTS 'webadmin'@'localhost' IDENTIFIED BY 'webadmin';
GRANT ALL PRIVILEGES ON *.* TO 'webadmin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EOF

    # Import database
    if [ -f "${USER_HOME}/web-adminTFG/installer/database/webadmin.sql" ]; then
        sudo mysql -u webadmin -pwebadmin < "${USER_HOME}/web-adminTFG/installer/database/webadmin.sql"
    else
        echo "El archivo ${USER_HOME}/web-adminTFG/webadmin.sql no se encuentra."
    fi;

}

init() {
cat << "EOF"
         /$$      /$$ /$$$$$$$$ /$$$$$$$   /$$$$$$  /$$$$$$$  /$$      /$$ /$$$$$$ /$$   /$$
        | $$  /$ | $$| $$_____/| $$__  $$ /$$__  $$| $$__  $$| $$$    /$$$|_  $$_/| $$$ | $$
        | $$ /$$$| $$| $$      | $$  \ $$| $$  \ $$| $$  \ $$| $$$$  /$$$$  | $$  | $$$$| $$
        | $$/$$ $$ $$| $$$$$   | $$$$$$$ | $$$$$$$$| $$  | $$| $$ $$/$$ $$  | $$  | $$ $$ $$
        | $$$$_  $$$$| $$__/   | $$__  $$| $$__  $$| $$  | $$| $$  $$$| $$  | $$  | $$  $$$$
        | $$$/ \  $$$| $$      | $$  \ $$| $$  | $$| $$  | $$| $$\  $ | $$  | $$  | $$\  $$$
        | $$/   \  $$| $$$$$$$$| $$$$$$$/| $$  | $$| $$$$$$$/| $$ \/  | $$ /$$$$$$| $$ \  $$
        |__/     \__/|________/|_______/ |__/  |__/|_______/ |__/     |__/|______/|__/  \__/
EOF
    echo ""
    echo "Este instalador va a instalar las siguientes dependencias: Apache, PHP, MySQL, Composer."
    echo "¿Deseas continuar? (Y/n)"
    read -n1 -s key
    if [[ "$key" == "Y" || "$key" == "y" ]]; then
        echo ""
        get_utils
        config_webpage
        config_apache
    elif [[ "$key" == "N" || "$key" == "n" ]]; then
        echo ""
        exit 1
    else
        echo ""
        echo "Opción no válida. Por favor, ejecuta el script de nuevo y presiona 'Y' o 'N'."
        exit 1
    fi;
   
}

init
