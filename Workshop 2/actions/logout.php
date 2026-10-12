
<?php
session_start();

// El cierre de sesión se solicita mediante POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

// Eliminamos los datos de la sesión.
$_SESSION = [];

// Eliminamos también la cookie de sesión del navegador.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruimos la sesión y regresamos al login.
session_destroy();

header('Location: ../index.php');
exit;
