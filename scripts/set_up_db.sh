#!/bin/bash
echo "Creando base de datos"
sudo mysql -u root < scripts/initiate_db.sql
echo "Base de datos creada"
