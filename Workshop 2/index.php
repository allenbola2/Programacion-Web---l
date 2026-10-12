
<?php
session_start();

// Si el usuario ya inició sesión, lo enviamos a su perfil.
if (isset($_SESSION['user_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}

require_once __DIR__ . '/pages/common/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center">Workshop 2</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Iniciar sesión</h4>
                </div>

                <div class="card-body">

                    <?php if (isset($_GET['registro'])): ?>
                        <div class="alert alert-success">
                            Usuario registrado correctamente.
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            No fue posible iniciar sesión. Verifique sus datos.
                        </div>
                    <?php endif; ?>

                    <!-- Enviamos las credenciales mediante POST -->
                    <form action="actions/login.php" method="POST">

                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Iniciar sesión
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="registro.php">Crear una cuenta</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/pages/common/footer.php'; ?>
