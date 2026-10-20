<?php
// Token CSRF para proteger formularios que modifican información.
require_once __DIR__ . '/auth.php';
function csrfToken(): string
{
    startSession();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verifyCsrf(): bool
{
    startSession();
    return isset($_POST['csrf_token']) && is_string($_POST['csrf_token'])
        && hash_equals(csrfToken(), $_POST['csrf_token']);
}
