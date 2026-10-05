<?php

$servidor = "127.0.0.1";
$usuario = "root";
$contrasena = "";
$baseDatos = "workshop1";
$puerto = 3307;

$conexion = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $baseDatos,
    $puerto
);

if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error);
    die("No fue posible conectar con la base de datos.");
}