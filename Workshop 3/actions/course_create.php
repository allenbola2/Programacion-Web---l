<?php
// Recibe el formulario de creación y guarda el curso mediante INSERT.
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/csrf.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/database.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
if (!verifyCsrf()) { http_response_code(403); exit('Solicitud no válida'); }
$data = courseInput();
if (courseError($data) !== null) { header('Location: ' . appUrl('pages/course_create.php?error=validation')); exit; }
try {
    $stmt = $conn->prepare('INSERT INTO courses (name, course_code, career_id, credits, description) VALUES (:name, :course_code, :career_id, :credits, :description)');
    $stmt->execute($data);
    header('Location: ' . appUrl('pages/courses.php?status=created'));
} catch (PDOException $e) {
    if ($e->getCode() === '23000') { header('Location: ' . appUrl('pages/course_create.php?error=duplicate')); }
    else { error_log($e->getMessage()); header('Location: ' . appUrl('pages/course_create.php?error=database')); }
}
exit;
