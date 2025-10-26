CREATE USER IF NOT EXISTS 'seed_dev'@'localhost' IDENTIFIED BY '7333';
GRANT ALL PRIVILEGES ON seed_lab_db.* TO 'seed_dev'@'localhost';
GRANT ALL PRIVILEGES ON seed_lab_db_test.* TO 'seed_dev'@'localhost';
FLUSH PRIVILEGES;