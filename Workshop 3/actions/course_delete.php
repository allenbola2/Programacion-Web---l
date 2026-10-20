<?php
// Eliminar cursos exige POST, sesión válida y token CSRF.
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/csrf.php';
require_once __DIR__ . '/../utils/database.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
if (!verifyCsrf()) { http_response_code(403); exit('Solicitud no válida'); }
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) { header('Location: ' . appUrl('pages/courses.php?error=not_found')); exit; }
try {
    $stmt = $conn->prepare('DELETE FROM courses WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $status = $stmt->rowCount() ? 'status=deleted' : 'error=not_found';
} catch (PDOException $e) {
    error_log($e->getMessage());
    $status = 'error=delete';
}
header('Location: ' . appUrl('pages/courses.php?' . $status));
exit;
