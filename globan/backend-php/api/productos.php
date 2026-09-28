<?php
require("conexion.php");

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $resultado = $conexion->query("SELECT * FROM Producto ORDER BY id DESC");
    $productos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
    echo json_encode($productos);
    exit();
}

if ($metodo === 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true);
    $nombre = trim($datos['nombre'] ?? '');
    $valor = $datos['valor'] ?? null;

    if ($nombre === '' || !is_numeric($valor) || $valor < 0) {
        http_response_code(400);
        echo json_encode(["error" => "Nombre y valor (numérico) son obligatorios"]);
        exit();
    }

    $stmt = $conexion->prepare("INSERT INTO Producto (nombre, valor) VALUES (?, ?)");
    $stmt->bind_param("sd", $nombre, $valor);

    if ($stmt->execute()) {
        echo json_encode(["id" => $stmt->insert_id, "nombre" => $nombre, "valor" => $valor]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo guardar el producto"]);
    }
    exit();
}

if ($metodo === 'DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el id del producto"]);
        exit();
    }

    $stmt = $conexion->prepare("DELETE FROM Producto WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["deleted" => $id]);
    exit();
}

http_response_code(405);
echo json_encode(["error" => "Método no soportado"]);
