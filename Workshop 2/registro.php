
<?php
require_once __DIR__ . '/utils/database.php';

// Cargamos las provincias desde la base de datos.
$stmt = $conn->query(
    'SELECT id, nombre FROM provincias ORDER BY nombre ASC'
);
$provincias = $stmt->fetchAll();

require_once __DIR__ . '/pages/common/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center">Registro de usuarios</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Crear cuenta</h4>
                </div>

                <div class="card-body">

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            $error = $_GET['error'];

                            if ($error === 'usuario_existe') {
                                echo 'Ese nombre de usuario ya está registrado.';
                            } elseif ($error === 'datos_invalidos') {
                                echo 'Revise los datos. La contraseña debe tener al menos 8 caracteres.';
                            } elseif ($error === 'provincia_invalida') {
                                echo 'Seleccione una provincia válida.';
                            } else {
                                echo 'No fue posible completar el registro.';
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="actions/registro.php" method="POST">

                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   maxlength="50"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   minlength="8"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="provincia_id">Provincia</label>

                            <select id="provincia_id"
                                    name="provincia_id"
                                    class="form-control"
                                    required>

                                <option value="">Seleccione una provincia</option>

                                <!-- foreach genera una opción por cada provincia -->
                                <?php foreach ($provincias as $provincia): ?>
                                    <option value="<?php echo (int) $provincia['id']; ?>">
                                        <?php echo htmlspecialchars($provincia['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Registrarse
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php">Volver al inicio de sesión</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/pages/common/footer.php'; ?>
