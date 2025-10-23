-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS seed_lab_db;

-- Borrar usuario viejo si existía
DROP USER IF EXISTS 'seed_dev'@'localhost';

-- Crear usuario y dar privilegios
CREATE USER 'seed_dev'@'localhost' IDENTIFIED BY '7333';
GRANT ALL PRIVILEGES ON seed_lab_db.* TO 'seed_dev'@'localhost';
FLUSH PRIVILEGES;
