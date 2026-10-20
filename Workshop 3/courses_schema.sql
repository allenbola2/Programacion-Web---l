-- Ejecutar en la base de datos workshop3 (phpMyAdmin).
CREATE TABLE IF NOT EXISTS courses (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    course_code VARCHAR(40) NOT NULL,
    career_id INT UNSIGNED NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_courses_code (course_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- career_id se guarda como entero, tal como solicita el enunciado.
-- No se crea tabla careers porque no está solicitada ni definida en week4.
