<?php
// Conexión PDO adaptada al entorno local del Workshop 3.
$dsn = 'mysql:host=127.0.0.1;port=3307;dbname=workshop3;charset=utf8mb4';
$dbUser = 'root';
$dbPassword = '';

try {
    $conn = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $exception) {
    error_log('Database connection error: ' . $exception->getMessage());
    http_response_code(500);
    exit('No se pudo conectar con la base de datos.');
}
