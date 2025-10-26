DROP DATABASE IF EXISTS seed_lab_db;
CREATE DATABASE seed_lab_db;
USE seed_lab_db;

SOURCE bdd/schema.sql;

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

SOURCE bdd/user.sql;