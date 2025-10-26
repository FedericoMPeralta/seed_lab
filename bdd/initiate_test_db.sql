DROP DATABASE IF EXISTS seed_lab_db_test;
CREATE DATABASE seed_lab_db_test;
USE seed_lab_db_test;

SOURCE bdd/schema.sql;
SOURCE bdd/user.sql;