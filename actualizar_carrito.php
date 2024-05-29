<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = intval($_POST["id_producto"]);
    $id_usuario = intval($_POST["id_usuario"]);
    $cantidad = intval($_POST["cantidad"]);

    if ($id_producto > 0 && $id_usuario > 0 && $cantidad > 0) {
        $stmt = $bd->prepare("UPDATE carrito SET cantidad = ? WHERE id_producto = ? AND id_usuario = ?");
        $stmt->bind_param("iii", $cantidad, $id_producto, $id_usuario);

        if ($stmt->execute()) {
            header("Location: carrito.php?id_usuario=$id_usuario");
            exit();
        } else {
            echo "Error al actualizar el carrito.";
        }

        $stmt->close();
    } else {
        echo "Datos inválidos.";
    }
}

$bd->close();
?>
