<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php 
    $bd = new mysqli("localhost", "root", "", "proyecto");
    if ($bd->connect_error) {
        die("Connection failed: " . $bd->connect_error);
    }

    // ID del usuario actual, obtenido de la URL
    $userId = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

    if (!empty($userId)) {
        // Consulta para obtener la cantidad de productos en el carrito del usuario
        $queryCarrito = mysqli_query($bd, "SELECT SUM(cantidad) AS cantidad FROM carrito WHERE id_usuario=$userId");
        $carritoData = mysqli_fetch_assoc($queryCarrito);
        $cantidadCarrito = $carritoData['cantidad'] ? $carritoData['cantidad'] : 0;

        // Consulta para obtener el nombre del usuario
        $queryUsuario = mysqli_query($bd, "SELECT nombre FROM usuarios WHERE id_usuario=$userId");
        $usuarioData = mysqli_fetch_assoc($queryUsuario);
        $nombreUsuario = $usuarioData['nombre'];
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
                    <tr>
                        <td><a href="#"><?php echo $nombreUsuario; ?></a></td>
                    </tr>
                </table>
            </div>
        </header>
        <?php
        // Consulta para obtener los productos
        $query = mysqli_query($bd, "SELECT id_producto, nombre, foto FROM productos;");
        ?>
        <div class="container">
            <?php
            while ($datos = mysqli_fetch_array($query)) {
                ?>
                <div class="item">
                    <h2><?php echo $datos["nombre"]; ?></h2>
                    <img src="<?php echo $datos["foto"]; ?>" alt="<?php echo $datos["nombre"]; ?>">
                    <a href="detalles.php?id_producto=<?php echo $datos["id_producto"]; ?>&id_usuario=<?php echo $userId; ?>">VER MÁS</a>
                    <form action="añadir_al_carrito.php" method="post">
                        <input type="hidden" name="id_usuario" value="<?php echo $userId; ?>">
                        <input type="hidden" name="id_producto" value="<?php echo $datos["id_producto"]; ?>">
                        <button type="submit">AÑADIR AL CARRITO</button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        echo "Usuario no identificado.";
    }

    $bd->close();
    ?>
    <footer>
        <img src="instagram.png"> <!-- Reemplaza "soul_logo.png" con la ruta de tu imagen -->
        <p><a href="https://www.instagram.com/soul_accessori">Soul Accesories</a></p>
    </footer>
</body>
</html>
