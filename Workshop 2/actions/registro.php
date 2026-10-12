
<?php
// Este archivo solo debe procesar formularios enviados por POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../registro.php');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$provincia_id = filter_input(
    INPUT_POST,
    'provincia_id',
    FILTER_VALIDATE_INT
);

// Validación de los datos recibidos.
if (
    !is_string($username) ||
    !is_string($password) ||
    trim($username) === '' ||
    strlen(trim($username)) > 50 ||
    strlen($password) < 8 ||
    !$provincia_id
) {
    header('Location: ../registro.php?error=datos_invalidos');
    exit;
}

$username = trim($username);

try {
    // Verificamos que la provincia exista.
    $stmt = $conn->prepare(
        'SELECT id FROM provincias WHERE id = :id'
    );
    $stmt->execute(['id' => $provincia_id]);

    if (!$stmt->fetch()) {
        header('Location: ../registro.php?error=provincia_invalida');
        exit;
    }

    // Comprobamos que el username no esté registrado.
    $stmt = $conn->prepare(
        'SELECT id FROM users WHERE username = :username'
    );
    $stmt->execute(['username' => $username]);

    if ($stmt->fetch()) {
        header('Location: ../registro.php?error=usuario_existe');
        exit;
    }

    // Guardamos un hash, nunca la contraseña original.
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        'INSERT INTO users (username, password_hash, provincia_id)
         VALUES (:username, :password_hash, :provincia_id)'
    );

    $stmt->execute([
        'username' => $username,
        'password_hash' => $password_hash,
        'provincia_id' => $provincia_id
    ]);

    header('Location: ../index.php?registro=exitoso');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../registro.php?error=servidor');
    exit;
}
