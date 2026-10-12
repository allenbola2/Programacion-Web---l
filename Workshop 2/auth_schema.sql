
CREATE DATABASE IF NOT EXISTS workshop2
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE workshop2;

-- Tabla que almacena las provincias de Costa Rica.
CREATE TABLE provincias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Registro de las siete provincias.
INSERT INTO provincias (nombre) VALUES
('San José'),
('Alajuela'),
('Cartago'),
('Heredia'),
('Guanacaste'),
('Puntarenas'),
('Limón');

-- Tabla de usuarios con contraseñas almacenadas como hash.
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    provincia_id INT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    -- Relación entre cada usuario y su provincia.
    CONSTRAINT fk_users_provincias
        FOREIGN KEY (provincia_id)
        REFERENCES provincias(id)
) ENGINE=InnoDB;
