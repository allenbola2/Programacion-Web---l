<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/csrf.php';
$courses = getCourses($conn);
$messages = ['created' => 'Curso creado correctamente.', 'updated' => 'Curso actualizado correctamente.', 'deleted' => 'Curso eliminado correctamente.'];
$status = (string) ($_GET['status'] ?? '');
$error = (string) ($_GET['error'] ?? '');
require_once __DIR__ . '/../inc/header.php';
?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Listado de cursos</h1>
    <a href="<?php echo courseEscape(appUrl('pages/course_create.php')); ?>" class="btn btn-primary">Crear curso</a>
  </div>
  <?php if (isset($messages[$status])): ?><div class="alert alert-success"><?php echo courseEscape($messages[$status]); ?></div><?php endif; ?>
  <?php if ($error === 'not_found'): ?><div class="alert alert-warning">No se encontró el curso.</div><?php endif; ?>
  <?php if ($error === 'delete'): ?><div class="alert alert-danger">No se pudo eliminar el curso.</div><?php endif; ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark"><tr><th>Nombre</th><th>Código de curso</th><th>ID carrera</th><th>Créditos</th><th>Descripción</th><th>Acciones</th></tr></thead>
      <tbody>
      <?php foreach ($courses as $course): ?>
        <tr>
          <td><?php echo courseEscape($course['name']); ?></td>
          <td><?php echo courseEscape($course['course_code']); ?></td>
          <td><?php echo (int) $course['career_id']; ?></td>
          <td><?php echo (int) $course['credits']; ?></td>
          <td><?php echo nl2br(courseEscape($course['description'])); ?></td>
          <td>
            <a class="btn btn-sm btn-warning mb-1" href="<?php echo courseEscape(appUrl('pages/course_edit.php?id=' . (int) $course['id'])); ?>">Editar</a>
            <!-- Eliminar SIEMPRE se realiza con POST. -->
            <form method="POST" action="<?php echo courseEscape(appUrl('actions/course_delete.php')); ?>" class="d-inline" onsubmit="return confirm('¿Eliminar este curso?');">
              <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <input type="hidden" name="csrf_token" value="<?php echo courseEscape(csrfToken()); ?>">
              <button type="submit" class="btn btn-sm btn-danger mb-1">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$courses): ?><tr><td colspan="6" class="text-center text-muted">No hay cursos registrados.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
