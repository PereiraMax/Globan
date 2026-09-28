<?php
// Conexión compartida por todos los endpoints de la API.
// Antes esta conexión era usada por páginas PHP que también generaban HTML;
// ahora cada endpoint SOLO devuelve JSON, para que el frontend en React lo consuma.

header("Access-Control-Allow-Origin: *"); // en producción, reemplazar "*" por el dominio del frontend
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// El navegador manda un OPTIONS antes de un POST/DELETE con JSON (preflight de CORS).
// Si no se responde acá, React nunca llega a recibir la respuesta real.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conexion = new mysqli("localhost", "root", "", "globan");
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $conexion->connect_error]);
    exit();
}
