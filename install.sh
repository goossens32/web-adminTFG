#!/bin/bash

# WEBADMIN INSTALLER, reccomended UPDATE and UPGRADE before execution of script!

# Get services
get_utils() {

    if [ ! -d /etc/apache2 ]; then
        echo "Apache no está instalado ..."
        sudo apt install apache2
    else
        echo "Apache está instalado"
    fi;

    if [ ! -d /etc/mysql ]; then
        echo "MySQL no está instalado ..."
        sudo apt install mysql-server
    else
        echo "MySQL está instalado"
    fi;

    if [ ! -d /etc/php ]; then
        echo "PHP no está instalado"
        sudo apt install php
    else
        echo "PHP está instalado"
    fi;

}

init() {
    get_utils
}

init