<?php
require("conexion.php");

$metodo = $_SERVER['REQUEST_METHOD'];

// GET /api/clientes.php -> listado completo
if ($metodo === 'GET') {
    $resultado = $conexion->query("SELECT * FROM Cliente ORDER BY id DESC");
    $clientes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $clientes[] = $fila;
    }
    echo json_encode($clientes);
    exit();
}

// POST /api/clientes.php -> alta de cliente (body en JSON, no en $_POST)
if ($metodo === 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true);
    $nombre = trim($datos['nombre'] ?? '');
    $telefono = trim($datos['telefono'] ?? '');

    if ($nombre === '' || $telefono === '') {
        http_response_code(400);
        echo json_encode(["error" => "Nombre y teléfono son obligatorios"]);
        exit();
    }

    // Prepared statement: reemplaza la concatenación directa del código original,
    // que era vulnerable a inyección SQL (INSERT INTO Cliente VALUES ('$nombre', ...)).
    $stmt = $conexion->prepare("INSERT INTO Cliente (nombre, telefono) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $telefono);

    if ($stmt->execute()) {
        echo json_encode(["id" => $stmt->insert_id, "nombre" => $nombre, "telefono" => $telefono]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo guardar el cliente"]);
    }
    exit();
}

// DELETE /api/clientes.php?id=3 -> baja de cliente
if ($metodo === 'DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el id del cliente"]);
        exit();
    }

    $stmt = $conexion->prepare("DELETE FROM Cliente WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["deleted" => $id]);
    exit();
}

http_response_code(405);
echo json_encode(["error" => "Método no soportado"]);
