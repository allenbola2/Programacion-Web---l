<?php
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/csrf.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../models/Course.php';

class CourseController
{
    private Course $model;

    public function __construct(PDO $db)
    {
        $this->model = new Course($db);
    }

    public function index(): void
    {
        requireLogin();
        $courses = $this->model->all();
        $messages = ['created' => 'Curso creado correctamente.', 'updated' => 'Curso actualizado correctamente.', 'deleted' => 'Curso eliminado correctamente.'];
        $status = (string) ($_GET['status'] ?? '');
        $error = (string) ($_GET['error'] ?? '');
        require __DIR__ . '/../inc/header.php';
        require __DIR__ . '/../views/courses/index.php';
        require __DIR__ . '/../inc/footer.php';
    }

    public function createForm(): void
    {
        requireLogin();
        $title = 'Crear curso';
        $action = appUrl('actions/course_create.php');
        $course = ['name' => '', 'course_code' => '', 'career_id' => '', 'credits' => '', 'description' => ''];
        require __DIR__ . '/../inc/header.php';
        require __DIR__ . '/../views/courses/form.php';
        require __DIR__ . '/../inc/footer.php';
    }

    public function editForm(): void
    {
        requireLogin();
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $course = $id ? $this->model->find($id) : null;
        if (!$course) { $this->redirect('pages/courses.php?error=not_found'); }
        $title = 'Editar curso';
        $action = appUrl('actions/course_update.php');
        require __DIR__ . '/../inc/header.php';
        require __DIR__ . '/../views/courses/form.php';
        require __DIR__ . '/../inc/footer.php';
    }

    public function store(): void
    {
        $this->authorizePost();
        $data = courseInput();
        if (courseError($data) !== null) { $this->redirect('pages/course_create.php?error=validation'); }
        try {
            $this->model->create($data);
            $this->redirect('pages/courses.php?status=created');
        } catch (PDOException $e) {
            if ($e->getCode() !== '23000') { error_log($e->getMessage()); }
            $this->redirect('pages/course_create.php?error=' . ($e->getCode() === '23000' ? 'duplicate' : 'database'));
        }
    }

    public function update(): void
    {
        $this->authorizePost();
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!$id || !$this->model->find($id)) { $this->redirect('pages/courses.php?error=not_found'); }
        $data = courseInput();
        if (courseError($data) !== null) { $this->redirect('pages/course_edit.php?id=' . $id . '&error=validation'); }
        try {
            $this->model->update($id, $data);
            $this->redirect('pages/courses.php?status=updated');
        } catch (PDOException $e) {
            if ($e->getCode() !== '23000') { error_log($e->getMessage()); }
            $this->redirect('pages/course_edit.php?id=' . $id . '&error=' . ($e->getCode() === '23000' ? 'duplicate' : 'database'));
        }
    }

    public function destroy(): void
    {
        $this->authorizePost();
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!$id) { $this->redirect('pages/courses.php?error=not_found'); }
        try {
            $result = $this->model->delete($id) ? 'status=deleted' : 'error=not_found';
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $result = 'error=delete';
        }
        $this->redirect('pages/courses.php?' . $result);
    }

    private function authorizePost(): void
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }
        if (!verifyCsrf()) { http_response_code(403); exit('Solicitud no válida'); }
    }

    private function redirect(string $path): never
    {
        header('Location: ' . appUrl($path));
        exit;
    }
}
