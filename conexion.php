<?php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_DATABASE') ?: 'globan';

$conexion = new mysqli($host, $user, $pass, $db);[cite: 2]
/*
$conexion = new mysqli("localhost", "root", "", "globan");*/
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
