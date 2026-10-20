<?php
// Recibe la edición de un curso y actualiza el registro mediante UPDATE.
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/csrf.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/database.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
if (!verifyCsrf()) { http_response_code(403); exit('Solicitud no válida'); }
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id || !getCourse($conn, $id)) { header('Location: ' . appUrl('pages/courses.php?error=not_found')); exit; }
$data = courseInput();
if (courseError($data) !== null) { header('Location: ' . appUrl('pages/course_edit.php?id=' . $id . '&error=validation')); exit; }
try {
    $data['id'] = $id;
    $stmt = $conn->prepare('UPDATE courses SET name=:name, course_code=:course_code, career_id=:career_id, credits=:credits, description=:description WHERE id=:id');
    $stmt->execute($data);
    header('Location: ' . appUrl('pages/courses.php?status=updated'));
} catch (PDOException $e) {
    $error = $e->getCode() === '23000' ? 'duplicate' : 'database';
    if ($error === 'database') error_log($e->getMessage());
    header('Location: ' . appUrl('pages/course_edit.php?id=' . $id . '&error=' . $error));
}
exit;
