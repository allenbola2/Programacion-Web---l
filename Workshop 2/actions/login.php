
<?php
session_start();

// Impedimos procesar el login mediante una petición GET.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (
    !is_string($username) ||
    !is_string($password) ||
    trim($username) === '' ||
    strlen(trim($username)) > 50 ||
    $password === ''
) {
    header('Location: ../index.php?error=datos');
    exit;
}

try {
    // Buscamos al usuario mediante una sentencia preparada.
    $stmt = $conn->prepare(
        'SELECT id, username, password_hash
         FROM users
         WHERE username = :username
         LIMIT 1'
    );

    $stmt->execute([
        'username' => trim($username)
    ]);

    $user = $stmt->fetch();

} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../index.php?error=servidor');
    exit;
}

// Comparamos la contraseña con el hash almacenado.
if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../index.php?error=credenciales');
    exit;
}

// Creamos una sesión para mantener al usuario autenticado.
session_regenerate_id(true);

$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];

header('Location: ../pages/dashboard.php');
exit;
