Se propone el desarrollo de un sistema web básico, basado en la arquitectura cliente-servidor, que permita gestionar información mediante el uso de una base de datos relacional.
En este contexto, los estudiantes deberán diseñar e implementar la lógica de negocio, respaldada por una base de datos que responda a la siguiente estructura:
🗄️ Base de datos: Globan
Tabla Cliente
id (clave primaria)
nombre
teléfono
Tabla Producto
id (clave primaria)
nombre
valor
Tabla Venta
id (clave primaria)
idCliente (clave foránea referenciada a Cliente)
idProducto (clave foránea referenciada a Producto)
cantidad (entero)

💻 Estructura del sistema
El sistema deberá organizarse en la siguiente estructura de archivos:
/globan/
   index.php
   menu.php
   clientes.php
   productos.php
   ventas.php
   style.css


🛠️ Consignas de trabajo
A partir de lo planteado, se deberá:
Crear la base de datos Globan en el gestor MySQL.
Definir las tablas Cliente, Producto y Venta, respetando claves primarias y foráneas.
Desarrollar la conexión entre PHP y la base de datos.
Implementar las páginas:
clientes.php: alta y visualización de clientes
productos.php: alta y visualización de productos
ventas.php: registro y consulta de ventas
Diseñar un archivo menu.php reutilizable para la navegación entre páginas.
Incorporar una página principal (index.php) que actúe como punto de acceso al sistema.
Aplicar estilos básicos mediante style.css para mejorar la presentación.


create database Globan;
use Globan;



Tablas Clientes:

create table Cliente(
 id int not null AUTO_INCREMENT,
 nombre varchar(60),
 telefono varchar(20),
 CONSTRAINT pkCliente primary key(id)   
)engine=innodb;


Tabla Productos:

create table Producto(
id int not null AUTO_INCREMENT,
nombre varchar(60),
valor double not null,
constraint pkProducto primary key(id)    
)engine=innodb;


Tabla Ventas:

use globan;
create table Venta(
id int not null AUTO_INCREMENT,
idCliente int not null,
idProducto int not null,
cantidad int not null,
constraint pk_idVenta primary key(id),
constraint fk_Venta1 FOREIGN key(idCliente) references Cliente(id),  
constraint fk_Venta2 foreign key(idProducto)references Producto(id)    
)engine=innodb;


 
Para la navegación del Sistema expondremos el archivo:

Index.php


<?php include("menu.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Globan</title>
</head>
<body>
    <h1>Sistema de Gestión Globan</h1>
</body>
</html>




Conexión.php

<?php include("menu.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Globan</title>
</head>
<body>
    <h1>Sistema de Gestión Globan</h1>
</body>
</html>




Menu.php


<link rel="stylesheet" href="style.css">
<div class="menu">
    <a href="index.php">🏠 Inicio</a>
    <a href="clientes.php">👤 Clientes</a>
    <a href="productos.php">📦 Productos</a>
    <a href="ventas.php">🧾 Ventas</a>
</div>




Style.css


body {
            font-family: Arial;
            text-align: center;
            background-color: #f4f4f4;
        }
table {
            display: center;
           
            width: 250px;
            margin: 15px auto;
            padding: 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
}
        h1 {
            margin-top: 50px;
        }


        .menu {
            margin-top: 40px;
        }


        .menu a {
            display: left;
           
            width: 250px;
            margin: 15px auto;
            padding: 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }


        .menu a:hover {
            background-color: #0056b3;
        }
   




Clientes.php


<?php include("menu.php");?>
<?php include("conexion.php"); ?>


<h2>Alta de Cliente</h2>


<form method="POST">
    Nombre: <input type="text" name="nombre" required>
    Teléfono: <input type="text" name="telefono" required>
    <button type="submit">Guardar</button>
</form>


<?php
if ($_POST) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];


    $sql = "INSERT INTO Cliente(nombre, telefono) VALUES ('$nombre','$telefono')";
    $conexion->query($sql);
}
?>


<h2>Listado de Clientes</h2>


<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Teléfono</th>
</tr>


<?php
$resultado = $conexion->query("SELECT * FROM Cliente");


while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['telefono']}</td>
          </tr>";
}
?>
</table>




Productos.php

<?php include("menu.php");?>
<?php include("conexion.php"); ?>


<h2>Alta de Producto</h2>


<form method="POST">
    Nombre: <input type="text" name="nombre" required>
    Valor: <input type="number" step="0.01" name="valor" required>
    <button type="submit">Guardar</button>
</form>


<?php
if ($_POST) {
    $nombre = $_POST['nombre'];
    $valor = $_POST['valor'];


    $sql = "INSERT INTO Producto(nombre, valor) VALUES ('$nombre','$valor')";
    $conexion->query($sql);
}
?>


<h2>Listado de Productos</h2>


<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Valor</th>
</tr>


<?php
$resultado = $conexion->query("SELECT * FROM Producto");


while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['valor']}</td>
          </tr>";
}
?>
</table>


Ventas.php

<?php include("menu.php");?>
<?php include("conexion.php"); ?>


<h2>Registrar Venta</h2>


<form method="POST">


    Cliente:
    <select name="idCliente">
        <?php
        $clientes = $conexion->query("SELECT * FROM Cliente");
        while ($c = $clientes->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['nombre']}</option>";
        }
        ?>
    </select>


    Producto:
    <select name="idProducto">
        <?php
        $productos = $conexion->query("SELECT * FROM Producto");
        while ($p = $productos->fetch_assoc()) {
            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
        }
        ?>
    </select>


    Cantidad:
    <input type="number" name="cantidad" required>


    <button type="submit">Guardar</button>
</form>


<?php
if ($_POST) {
    $idCliente = $_POST['idCliente'];
    $idProducto = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];


    $sql = "INSERT INTO Venta(idCliente, idProducto, cantidad)
            VALUES ('$idCliente','$idProducto','$cantidad')";
    $conexion->query($sql);
}
?>


<h2>Listado de Ventas</h2>


<table border="1">
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Producto</th>
    <th>Cantidad</th>
</tr>


<?php
$sql = "SELECT v.id, c.nombre as cliente, p.nombre as producto, v.cantidad
        FROM Venta v
        JOIN Cliente c ON v.idCliente = c.id
        JOIN Producto p ON v.idProducto = p.id";


$resultado = $conexion->query($sql);


while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['cliente']}</td>
            <td>{$fila['producto']}</td>
            <td>{$fila['cantidad']}</td>
          </tr>";
}
?>
</table>






