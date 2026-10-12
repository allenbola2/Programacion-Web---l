
<?php
session_start();

// Solo un usuario autenticado puede modificar su perfil.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/dashboard.php');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

$username = $_POST['username'] ?? null;
$provincia_id = filter_input(
    INPUT_POST,
    'provincia_id',
    FILTER_VALIDATE_INT
);

if (
    !is_string($username) ||
    trim($username) === '' ||
    strlen(trim($username)) > 50 ||
    !$provincia_id
) {
    header('Location: ../pages/dashboard.php?error=datos');
    exit;
}

$username = trim($username);

try {
    // Comprobamos que la provincia seleccionada exista.
    $stmt = $conn->prepare(
        'SELECT id FROM provincias WHERE id = :id'
    );
    $stmt->execute(['id' => $provincia_id]);

    if (!$stmt->fetch()) {
        header('Location: ../pages/dashboard.php?error=provincia');
        exit;
    }

    // Actualizamos únicamente al usuario de la sesión actual.
    $stmt = $conn->prepare(
        'UPDATE users
         SET username = :username,
             provincia_id = :provincia_id
         WHERE id = :id'
    );

    $stmt->execute([
        'username' => $username,
        'provincia_id' => $provincia_id,
        'id' => $_SESSION['user_id']
    ]);

    $_SESSION['username'] = $username;

    header('Location: ../pages/dashboard.php?actualizado=1');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../pages/dashboard.php?error=servidor');
    exit;
}
