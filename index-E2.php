<?php
require 'conexion.php'; // Archivo que conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $producto = $_POST['producto'];
    $precio_unitario = $_POST['precio_unitario'];
    $cantidad = $_POST['cantidad'];
    $precio_total = $precio_unitario * $cantidad;

    // Inserta datos de la persona
    $stmt = $mysqli->prepare("INSERT INTO personas (nombre, dni) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $dni);
    $stmt->execute();
    $persona_id = $stmt->insert_id;

    // Inserta datos del producto
    $stmt = $mysqli->prepare("INSERT INTO productos (producto, precio_unitario, cantidad, id_persona) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdii", $producto, $precio_unitario, $cantidad, $persona_id);
    $stmt->execute();
    $stmt->close();

    echo "Datos guardados correctamente.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Compras</title>
</head>
<body>
    <h1>Registro de Compras</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br>

        <label for="producto">Producto:</label>
        <input type="text" id="producto" name="producto" required><br>

        <label for="precio_unitario">Precio Unitario:</label>
        <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" required><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required><br>

        <button type="submit">Guardar</button>
    </form>

    <form method="POST" action="generar_pdf.php">
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>
