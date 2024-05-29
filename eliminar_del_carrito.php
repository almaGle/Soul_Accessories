<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = intval($_POST["id_producto"]);
    $id_usuario = intval($_POST["id_usuario"]);

    if ($id_producto > 0 && $id_usuario > 0) {
        $stmt = $bd->prepare("DELETE FROM carrito WHERE id_producto = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_producto, $id_usuario);

        if ($stmt->execute()) {
            header("Location: carrito.php?id_usuario=$id_usuario");
            exit();
        } else {
            echo "Error al eliminar el producto del carrito.";
        }

        $stmt->close();
    } else {
        echo "Producto inválido.";
    }
}

$bd->close();
?>
