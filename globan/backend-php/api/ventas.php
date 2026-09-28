<?php
require("conexion.php");

$metodo = $_SERVER['REQUEST_METHOD'];

// GET /api/ventas.php -> listado con nombre de cliente/producto y total calculado
if ($metodo === 'GET') {
    $sql = "SELECT v.id, v.cantidad,
                   c.id AS idCliente, c.nombre AS clienteNombre,
                   p.id AS idProducto, p.nombre AS productoNombre, p.valor,
                   (v.cantidad * p.valor) AS total
            FROM Venta v
            JOIN Cliente c ON c.id = v.idCliente
            JOIN Producto p ON p.id = v.idProducto
            ORDER BY v.id DESC";
    $resultado = $conexion->query($sql);
    $ventas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $ventas[] = $fila;
    }
    echo json_encode($ventas);
    exit();
}

// POST /api/ventas.php -> registrar una venta
if ($metodo === 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true);
    $idCliente = intval($datos['idCliente'] ?? 0);
    $idProducto = intval($datos['idProducto'] ?? 0);
    $cantidad = intval($datos['cantidad'] ?? 0);

    if ($idCliente <= 0 || $idProducto <= 0 || $cantidad <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Cliente, producto y cantidad son obligatorios"]);
        exit();
    }

    $stmt = $conexion->prepare("INSERT INTO Venta (idCliente, idProducto, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $idCliente, $idProducto, $cantidad);

    if ($stmt->execute()) {
        echo json_encode(["id" => $stmt->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo registrar la venta"]);
    }
    exit();
}

if ($metodo === 'DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el id de la venta"]);
        exit();
    }

    $stmt = $conexion->prepare("DELETE FROM Venta WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["deleted" => $id]);
    exit();
}

http_response_code(405);
echo json_encode(["error" => "Método no soportado"]);
