-- Crear la base de datos
DROP DATABASE IF EXISTS seed_lab_db_test;
CREATE DATABASE seed_lab_db_test;
USE seed_lab_db_test;

CREATE TABLE muestras (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(255) UNIQUE NOT NULL,
  numero_precinto VARCHAR(255) UNIQUE NOT NULL,
  empresa VARCHAR(255),
  especie VARCHAR(255),
  cantidad_semillas INT UNSIGNED,
  fecha_recepcion DATE,
  fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE resultados (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  muestra_id INT UNSIGNED NOT NULL,
  poder_germinativo DECIMAL(5,2) CHECK (poder_germinativo BETWEEN 0 AND 100),
  pureza DECIMAL(5,2) CHECK (pureza BETWEEN 0 AND 100),
  materiales_inertes TEXT,
  fecha_recepcion DATE,
  fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (muestra_id) REFERENCES muestras(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Crear usuario y dar privilegios
CREATE USER IF NOT EXISTS 'seed_dev'@'localhost' IDENTIFIED BY '7333';
GRANT ALL PRIVILEGES ON seed_lab_db_test.* TO 'seed_dev'@'localhost';
FLUSH PRIVILEGES;


