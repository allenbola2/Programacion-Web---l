
<?php
// Configuración de MySQL en nuestro entorno local.
$host = '127.0.0.1';
$port = 3307;
$dbname = 'workshop2';
$dbUser = 'root';
$dbPassword = '';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    // PDO permite trabajar con consultas preparadas.
    $conn = new PDO($dsn, $dbUser, $dbPassword);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die('No fue posible conectar con la base de datos.');
}
