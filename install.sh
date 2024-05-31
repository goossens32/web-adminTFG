#!/bin/bash

# WEBADMIN INSTALLER, reccomended UPDATE and UPGRADE before execution of script!

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

config_apache() {
    echo "Configurando Apache ..."
    sudo cp -v ./installer/webadmin.conf /etc/apache2/sites-available/
    # Creating certs
    echo "Generando clave privada ..."
    # Private cert
    sudo openssl genpkey -algorithm RSA -out /etc/ssl/private/webadmin-self.key -aes256
    echo ""
    echo "Firmando certificado ..."
    sudo openssl req -new -key /etc/ssl/private/webadmin-self.key -out /etc/ssl/certs/webadmin-self.crt
    echo ""
    # Ennabling needed apache mods and sites
    sudo a2enmod ssl
    sudo a2enmod php8.1
    sudo a2enmod rewrite
    sudo a2ensite webadmin.conf
    # Restart Apache
    sudo systemctl restart apache2.service
}

config_webpage() {
    if [ ! -d /var/www/webadmin ]; then
        sudo mkdir -v /var/www/webadmin
    fi;
    sudo cp -r public/ /var/www/webadmin/
    sudo cp -r src/ /var/www/webadmin/
    sudo cp -r composer* /var/www/webadmin/
}

# config_mysql (

# )



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
    echo "Este instalador va a instalar las siguientes dependencias: Apache, PHP, MySQL, Composer"
    get_utils
    config_apache
    config_webpage
}

init
