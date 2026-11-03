<?php
require_once __DIR__ . '/../controllers/CourseController.php';
(new CourseController($conn))->editForm();
