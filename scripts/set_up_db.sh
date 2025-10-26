#!/bin/bash
echo "Creando bases de datos..."
sudo mysql -u root < bdd/initiate_db.sql
sudo mysql -u root < bdd/initiate_test_db.sql
echo "Bases de datos creadas exitosamente"