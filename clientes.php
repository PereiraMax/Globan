<?php include("menu.php");?>
<?php include("conexion.php"); ?>

<h2>Alta de Cliente</h2>

<form method="POST" >
    <fieldset>
      
    Nombre: <input type="text" name="nombre" required>
    Teléfono: <input type="text" name="telefono" required>
    <button type="submit">Guardar</button>
</fieldset>
</form>
<?php
// insertar los datos en la base de datos
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
