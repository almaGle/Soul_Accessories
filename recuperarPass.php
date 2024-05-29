<?php
include("conexion.php");
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["correo"]) && isset($_POST["newpass"])) {
        $correo = $_POST["correo"];
        $newPassword = $_POST["newpass"];

        if (strlen($newPassword) >= 8) {
            $query = "UPDATE usuarios SET pass = '$newPassword' WHERE correo = '$correo'";
            $resultado = mysqli_query($bd, $query);

            if ($resultado) {
                if (mysqli_affected_rows($bd) > 0) {
                    $mensaje = "Contraseña actualizada correctamente";
                } else {
                    $mensaje = "Correo no registrado";
                }
            } else {
                $mensaje = "Error al actualizar la contraseña";
            }
        } else {
            $mensaje = "La nueva contraseña debe tener al menos 8 caracteres.";
        }
    } else {
        $mensaje = "Por favorcompleta todos los campos.";
    }
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilo.css">
        <title>Recuperar contraseña</title>
    </head>
    <body>
        <div class="container">
            <form class="formulario" action="recuperarPass.php" method="post">
                CORREO <input type="text" name="correo" placeholder="Ingresa tu email" required>
                <br>
                NUEVA CONTRASEÑA <input type="password" name="newpass" placeholder="Escribe tu nueva contraseña, mínimo 8 caracteres" required>
                <br>
                <input type="submit" value="Recuperar">
            </form>
    <?php 
    if ($mensaje != "") {
        echo "<p style='color:red;'>$mensaje</p>";
    }
    ?>
</div>
<footer>
        <img src="instagram.png"> <!-- Reemplaza "soul_logo.png" con la ruta de tu imagen -->
        <p><a href="https://www.instagram.com/soul_accessori">Soul Accesories</a></p>
    </footer>
</body>
</html>

