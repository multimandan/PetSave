-- This is the database for pets
-- initial script that creates the tables we will use

CREATE DATABASE PetDB;
CREATE USER 'db_user'@'localhost';
GRANT ALL PRIVILEGES ON PetDB.* TO db_user@localhost IDENTIFIED BY 'password';
