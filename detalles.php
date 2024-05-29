<?php
$bd = new mysqli("localhost", "root", "", "proyecto");
if ($bd->connect_error) {
    die("Connection failed: " . $bd->connect_error);
}

$id_producto = isset($_GET['id_producto']) ? intval($_GET['id_producto']) : '';
$userId = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : '';

// Obtener la cantidad de productos en el carrito
$cantidadCarrito = 0;
if ($userId) {
    $carritoQuery = "SELECT SUM(cantidad) AS cantidad FROM carrito WHERE id_usuario = $userId";
    $carritoResult = mysqli_query($bd, $carritoQuery);
    if ($carritoData = mysqli_fetch_assoc($carritoResult)) {
        $cantidadCarrito = $carritoData['cantidad'] ? $carritoData['cantidad'] : 0;
    }
}

if ($id_producto) {
    $query = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $result = mysqli_query($bd, $query);

    if ($datos = mysqli_fetch_array($result)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($datos["nombre"]); ?> - Detalles del Producto</title>
            <link rel="stylesheet" href="estilo.css">
        </head>
        <body>
        <header>
            <div class="barra">
                <table class="accesorapido">
                    <tr>
                        <th><a href="productos.php?id_usuario=<?php echo $userId; ?>">Inicio</a></th>
                        <th><a href="direccion.php?id_usuario=<?php echo $userId; ?>">Direccion</a></th>
                        <th><a href="cuenta.php?id_usuario=<?php echo $userId; ?>">Cuenta</a></th>
                        <th><a href="pedidos.php?id_usuario=<?php echo $userId; ?>">Pedidos</a></th>
                        <th><a href="carrito.php?id_usuario=<?php echo $userId; ?>">Carrito (<?php echo $cantidadCarrito; ?>)</a></th>
                    </tr>
                </table>
            </div>
        </header>
        <div class="contenedor">
            <div class="imagen">
                <img src="<?php echo htmlspecialchars($datos["foto"]); ?>" alt="<?php echo htmlspecialchars($datos["nombre"]); ?>">
            </div>
            <div class="informacion">
                <h1><?php echo htmlspecialchars($datos["nombre"]); ?></h1>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($datos["descripcion"]); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($datos["precio"], 2); ?></p>
                <p><strong>Existencias:</strong> <?php echo $datos["existencias"]; ?></p>
            </div>
        </div>

        <a href="productos.php?id_usuario=<?php echo $userId; ?>" class="regresar-btn">REGRESAR</a>
        <footer>
            <img src="instagram.png" alt="Soul Accesories"> <!-- Reemplaza "instagram.png" con la ruta de tu imagen -->
            <p><a href="https://www.instagram.com/soul_accessori">Soul Accesories</a></p>
        </footer>
        </body>
        </html>
        <?php
    } else {
        echo "Producto no encontrado";
    }
} else {
    echo "ID del producto no especificado";
}

$bd->close();
?>
