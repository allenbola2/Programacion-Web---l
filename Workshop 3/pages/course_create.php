<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/csrf.php';
require_once __DIR__ . '/../utils/courses.php';
$title = 'Crear curso';
$action = appUrl('actions/course_create.php');
$course = ['name' => '', 'course_code' => '', 'career_id' => '', 'credits' => '', 'description' => ''];
require_once __DIR__ . '/../inc/header.php';
require __DIR__ . '/course_form.php';
require_once __DIR__ . '/../inc/footer.php';
