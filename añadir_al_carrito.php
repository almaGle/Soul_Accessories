<?php
$bd = new mysqli("localhost", "root", "", "proyecto");
if ($bd->connect_error) {
    die("Connection failed: " . $bd->connect_error);
}

$id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : '';
$id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : '';

if ($id_usuario && $id_producto) {
    // Verificar si el producto ya está en el carrito
    $query = "SELECT cantidad FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto";
    $result = mysqli_query($bd, $query);

    if (mysqli_num_rows($result) > 0) {
        // Si el producto ya está en el carrito, actualizar la cantidad
        $row = mysqli_fetch_assoc($result);
        $nuevaCantidad = $row['cantidad'] + 1;
        $query = "UPDATE carrito SET cantidad = $nuevaCantidad WHERE id_usuario = $id_usuario AND id_producto = $id_producto";
    } else {
        // Si el producto no está en el carrito, añadirlo
        $query = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ($id_usuario, $id_producto, 1)";
    }

    if (mysqli_query($bd, $query)) {
        // Redirigir de vuelta a la página de productos con el id_usuario
        header("Location: productos.php?id_usuario=$id_usuario");
        exit();
    } else {
        die("Error al añadir el producto al carrito: " . mysqli_error($bd));
    }
} else {
    die("Datos inválidos");
}

$bd->close();
?>
