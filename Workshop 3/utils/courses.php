<?php
// Funciones reutilizables para el CRUD de cursos.
function getCourses(PDO $conn): array
{
    return $conn->query('SELECT id, name, course_code, career_id, credits, description FROM courses ORDER BY id DESC')->fetchAll();
}

function getCourse(PDO $conn, int $id): ?array
{
    $stmt = $conn->prepare('SELECT id, name, course_code, career_id, credits, description FROM courses WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $course = $stmt->fetch();
    return $course ?: null;
}

function courseInput(): array
{
    return [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'course_code' => trim((string) ($_POST['course_code'] ?? '')),
        'career_id' => filter_var($_POST['career_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]),
        'credits' => filter_var($_POST['credits'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 255]]),
        'description' => trim((string) ($_POST['description'] ?? '')),
    ];
}

function courseError(array $data): ?string
{
    if ($data['name'] === '' || $data['course_code'] === '' || $data['description'] === '') {
        return 'Todos los campos son obligatorios.';
    }
    if (mb_strlen($data['name']) > 150 || mb_strlen($data['course_code']) > 40) {
        return 'El nombre o el código superan la longitud permitida.';
    }
    if ($data['career_id'] === false || $data['credits'] === false) {
        return 'El ID de carrera debe ser positivo y los créditos deben estar entre 0 y 255.';
    }
    return null;
}

// Escapar textos antes de mostrarlos en HTML para prevenir XSS.
function courseEscape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
