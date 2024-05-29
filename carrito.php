<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Carrito de Compras</title>
</head>
<body>
    <?php
    $bd = new mysqli("localhost", "root", "", "proyecto");
    if ($bd->connect_error) {
        die("Connection failed: " . $bd->connect_error);
    }

    $userId = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : '';

    if ($userId) {
        // Consulta para obtener la cantidad de productos en el carrito del usuario
        $queryCarrito = mysqli_query($bd, "SELECT SUM(cantidad) AS cantidad FROM carrito WHERE id_usuario=$userId");
        $carritoData = mysqli_fetch_assoc($queryCarrito);
        $cantidadCarrito = $carritoData['cantidad'] ? $carritoData['cantidad'] : 0;
        ?>
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
        <?php

        $query = "SELECT p.id_producto, p.nombre, p.precio, p.foto, c.cantidad 
                  FROM carrito c 
                  JOIN productos p ON c.id_producto = p.id_producto 
                  WHERE c.id_usuario = $userId";

        $result = mysqli_query($bd, $query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($bd));
        }

        $total = 0;
        ?>

        <div class="principal">
            <h1>Carrito de Compras</h1>
            <table class="carrito">
                <tr>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($datos = mysqli_fetch_array($result)) { 
                    $subtotal = $datos["precio"] * $datos["cantidad"];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $datos["nombre"]; ?></td>
                    <td>
                        <a href="detalles.php?id_producto=<?php echo $datos["id_producto"]; ?>&id_usuario=<?php echo $userId; ?>">
                            <img src="<?php echo $datos["foto"]; ?>" alt="<?php echo $datos["nombre"]; ?>" style="width: 100px; height: 100px;">
                        </a>
                    </td>
                    <td>$<?php echo number_format($datos["precio"], 2); ?></td>
                    <td>
                        <form action="actualizar_carrito.php" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $datos["id_producto"]; ?>">
                            <input type="hidden" name="id_usuario" value="<?php echo $userId; ?>">
                            <input type="number" name="cantidad" value="<?php echo $datos["cantidad"]; ?>" min="1" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form action="eliminar_del_carrito.php" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $datos["id_producto"]; ?>">
                            <input type="hidden" name="id_usuario" value="<?php echo $userId; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <div class="cajadetotal">
                <p>Total: $<?php echo number_format($total, 2); ?></p>
            </div>
        </div>
        <?php
    } else {
        echo "Usuario no identificado.";
    }

    $bd->close();
    ?>
    </div>
    <footer>
        <img src="instagram.png" alt="Soul Accesories"> <!-- Asegúrate de tener la imagen en el directorio adecuado -->
        <p><a href="https://www.instagram.com/soul_accessori">Soul Accesories</a></p>
    </footer>
</body>
</html>
