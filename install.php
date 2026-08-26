<?php
$host = "localhost";
$user = "root";
$pass = "";

// 1. Conexión inicial al servidor MySQL
$conexion = new mysqli($host, $user, $pass);

if ($conexion->connect_error) {
    die("Error en la conexión con el servidor: " . $conexion->connect_error);
}

// 2. Creación de la base de datos
$sqlBD = "CREATE DATABASE IF NOT EXISTS Globan";
if (!$conexion->query($sqlBD)) {
    die("Error al crear la base de datos: " . $conexion->error);
}

// 3. Selección de la base de datos
$conexion->select_db("Globan");

// 4. Consultas para la creación de tablas
$tablas = [
    "Cliente" => "CREATE TABLE IF NOT EXISTS Cliente (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(60),
        telefono VARCHAR(20),
        CONSTRAINT pkCliente PRIMARY KEY (id)
    ) ENGINE=InnoDB;",

    "Producto" => "CREATE TABLE IF NOT EXISTS Producto (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(60),
        valor DOUBLE NOT NULL,
        CONSTRAINT pkProducto PRIMARY KEY (id)
    ) ENGINE=InnoDB;",

    "Venta" => "CREATE TABLE IF NOT EXISTS Venta (
        id INT NOT NULL AUTO_INCREMENT,
        idCliente INT NOT NULL,
        idProducto INT NOT NULL,
        cantidad INT NOT NULL,
        CONSTRAINT pk_idVenta PRIMARY KEY (id),
        CONSTRAINT fk_Venta1 FOREIGN KEY (idCliente) REFERENCES Cliente(id),
        CONSTRAINT fk_Venta2 FOREIGN KEY (idProducto) REFERENCES Producto(id)
    ) ENGINE=InnoDB;"
];

// 5. Ejecución secuencial
foreach ($tablas as $nombre => $sql) {
    if ($conexion->query($sql) === TRUE) {
        echo "Tabla <strong>$nombre</strong> procesada correctamente.<br>";
    } else {
        echo "Error al crear la tabla $nombre: " . $conexion->error . "<br>";
    }
}

$conexion->close();
echo "<br><strong>Proceso de instalación finalizado con éxito.</strong>";
?>