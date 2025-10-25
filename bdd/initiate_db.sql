-- Crear la base de datos
DROP DATABASE IF EXISTS seed_lab_db;
CREATE DATABASE seed_lab_db;
USE seed_lab_db;

CREATE TABLE muestras (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(255) UNIQUE NOT NULL,
  numero_precinto VARCHAR(255) UNIQUE NOT NULL,
  empresa VARCHAR(255),
  especie VARCHAR(255),
  cantidad_semillas INT UNSIGNED,
  fecha_recepcion DATE DEFAULT CURRENT_TIMESTAMP,
  fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE resultados (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  muestra_id INT UNSIGNED NOT NULL,
  poder_germinativo DECIMAL(5,2) CHECK (poder_germinativo BETWEEN 0 AND 100),
  pureza DECIMAL(5,2) CHECK (pureza BETWEEN 0 AND 100),
  materiales_inertes TEXT,
  fecha_recepcion DATE DEFAULT CURRENT_TIMESTAMP,
  fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (muestra_id) REFERENCES muestras(id)
);

-- Crear muestras y resultados de ejemplo

INSERT INTO muestras (codigo, numero_precinto, empresa, especie, cantidad_semillas, fecha_recepcion)
VALUES
('SEED-2022-0001', '101010', NULL, 'Trigo', 1200, '2025-10-20'),
('SEED-2024-0030', '11110000', '27 SRL', 'Soja', NULL, '2025-10-21'),
('SEED-2023-0007', '6A7C01', '40 Inc', NULL, 500, '2025-10-22');

INSERT INTO resultados (muestra_id, poder_germinativo, pureza, materiales_inertes, fecha_recepcion)
VALUES
(1, 85, 92, 'Restos de paja', '2025-10-21'),

(2, 87.50, 94.20, NULL, '2025-10-22'),

(2, 88, 95.1, '', '2025-10-23');


-- Crear usuario y dar privilegios
DROP USER IF EXISTS 'seed_dev'@'localhost';
CREATE USER 'seed_dev'@'localhost' IDENTIFIED BY '7333';
GRANT ALL PRIVILEGES ON seed_lab_db.* TO 'seed_dev'@'localhost';
FLUSH PRIVILEGES;


