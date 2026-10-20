<?php
require_once __DIR__ . '/../utils/config.php';
// Encabezado compartido para las páginas protegidas.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workshop 3 - Cursos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="<?php echo htmlspecialchars(appUrl('pages/dashboard.php'), ENT_QUOTES, 'UTF-8'); ?>">Workshop 3</a>
  <div class="navbar-nav mr-auto">
    <a class="nav-item nav-link" href="<?php echo htmlspecialchars(appUrl('pages/profile.php'), ENT_QUOTES, 'UTF-8'); ?>">Perfil</a>
    <a class="nav-item nav-link" href="<?php echo htmlspecialchars(appUrl('pages/courses.php'), ENT_QUOTES, 'UTF-8'); ?>">Cursos</a>
    <a class="nav-item nav-link" href="<?php echo htmlspecialchars(appUrl('users.php'), ENT_QUOTES, 'UTF-8'); ?>">Usuarios</a>
  </div>
  <form action="<?php echo htmlspecialchars(appUrl('actions/logout.php'), ENT_QUOTES, 'UTF-8'); ?>" method="POST" class="mb-0">
    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
  </form>
</nav>
