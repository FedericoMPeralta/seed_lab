#!/bin/bash
# Crea la bdd usando el script initiate_db.sql

echo "Actualizando repositorios..."
sudo apt update

echo "Instalando PHP y extensiones necesarias..."
sudo apt install -y php php-mysql php-intl php-xml php-mbstring php-zip

echo "Instalando MySQL..."
sudo apt install -y mysql-server

echo "Instalando Composer..."
sudo apt install -y composer

echo "Instalando herramientas adicionales"
sudo apt install -y git unzip

echo "Instalando dependencias de CakePHP del proyecto..."
composer install

echo "Todo listo"
