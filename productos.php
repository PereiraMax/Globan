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
