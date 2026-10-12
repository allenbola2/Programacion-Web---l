
<?php
session_start();

// Protegemos la página: solo usuarios autenticados pueden entrar.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

// Obtenemos los datos del usuario y su provincia.
$stmt = $conn->prepare(
    'SELECT users.id, users.username, users.provincia_id,
            provincias.nombre AS provincia
     FROM users
     LEFT JOIN provincias
     ON users.provincia_id = provincias.id
     WHERE users.id = :id'
);

$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php');
    exit;
}

// Cargamos las provincias para permitir modificar la selección.
$stmt = $conn->query(
    'SELECT id, nombre FROM provincias ORDER BY nombre ASC'
);
$provincias = $stmt->fetchAll();

require_once __DIR__ . '/common/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center">Mi perfil</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Información del usuario
                </div>

                <div class="card-body">

                    <?php if (isset($_GET['actualizado'])): ?>
                        <div class="alert alert-success">
                            Perfil actualizado correctamente.
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            No se pudo actualizar el perfil.
                            Verifique los datos.
                        </div>
                    <?php endif; ?>

                    <p>
                        <strong>ID:</strong>
                        <?php echo (int) $user['id']; ?>
                    </p>

                    <p>
                        <strong>Provincia actual:</strong>
                        <?php echo htmlspecialchars(
                            $user['provincia'] ?? 'Sin asignar',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </p>

                    <!-- El usuario puede modificar sus propios datos -->
                    <form action="../actions/actualizar_perfil.php"
                          method="POST">

                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   maxlength="50"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="provincia_id">Provincia</label>

                            <select id="provincia_id"
                                    name="provincia_id"
                                    class="form-control"
                                    required>

                                <option value="">Seleccione una provincia</option>

                                <?php foreach ($provincias as $provincia): ?>
                                    <option
                                        value="<?php echo (int) $provincia['id']; ?>"
                                        <?php echo $user['provincia_id'] == $provincia['id'] ? 'selected' : ''; ?>>

                                        <?php echo htmlspecialchars(
                                            $provincia['nombre'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Guardar cambios
                        </button>
                    </form>

                    <hr>

                    <form action="../actions/logout.php" method="POST">
                        <button type="submit"
                                class="btn btn-danger btn-block">
                            Cerrar sesión
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/common/footer.php'; ?>
