<?php
// Formulario compartido para crear y editar cursos.
?>
<div class="container" style="max-width: 750px;">
  <h1 class="h3 mb-4"><?php echo courseEscape($title); ?></h1>
  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
      <?php echo $_GET['error'] === 'duplicate' ? 'Ya existe un curso con ese código.' : 'Revisá los campos del formulario e intentá nuevamente.'; ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="<?php echo courseEscape($action); ?>">
    <input type="hidden" name="csrf_token" value="<?php echo courseEscape(csrfToken()); ?>">
    <?php if (isset($course['id'])): ?><input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>"><?php endif; ?>
    <div class="form-group"><label for="name">Nombre</label><input class="form-control" id="name" name="name" maxlength="150" value="<?php echo courseEscape($course['name']); ?>" required></div>
    <div class="form-group"><label for="course_code">Código de curso</label><input class="form-control" id="course_code" name="course_code" maxlength="40" value="<?php echo courseEscape($course['course_code']); ?>" required></div>
    <div class="form-group"><label for="career_id">ID de la carrera</label><input class="form-control" type="number" min="1" id="career_id" name="career_id" value="<?php echo courseEscape($course['career_id']); ?>" required></div>
    <div class="form-group"><label for="credits">Créditos</label><input class="form-control" type="number" min="0" max="255" id="credits" name="credits" value="<?php echo courseEscape($course['credits']); ?>" required></div>
    <div class="form-group"><label for="description">Descripción del curso</label><textarea class="form-control" id="description" name="description" rows="4" required><?php echo courseEscape($course['description']); ?></textarea></div>
    <button type="submit" class="btn btn-primary">Guardar curso</button>
    <a href="<?php echo courseEscape(appUrl('pages/courses.php')); ?>" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
