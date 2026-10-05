<?php

// Conexión a la base de datos
$conexion = new mysqli("127.0.0.1", "root", "", "workshop1", 3307);

// Verificar si hubo un error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos enviados desde index.php
$username = $_POST["username"];
$password = $_POST["password"];

// Buscar un usuario que tenga ese username y password
$sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$resultado = $stmt->get_result();

// Verificar si se encontró el usuario
if ($resultado->num_rows > 0) {

    // Usuario y contraseña correctos
    header("Location: usuario_existe.php");
    exit;

} else {

    // Usuario o contraseña incorrectos
    header("Location: index.php?error=1");
    exit;
}

?>