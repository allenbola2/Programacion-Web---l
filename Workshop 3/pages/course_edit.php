<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/csrf.php';
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$course = $id ? getCourse($conn, $id) : null;
if (!$course) {
    header('Location: ' . appUrl('pages/courses.php?error=not_found'));
    exit;
}
$title = 'Editar curso';
$action = appUrl('actions/course_update.php');
require_once __DIR__ . '/../inc/header.php';
require __DIR__ . '/course_form.php';
require_once __DIR__ . '/../inc/footer.php';
