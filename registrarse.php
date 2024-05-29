<?php
include("conexion.php");
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!empty($username) && !empty($nombre) && !empty($email) && !empty($pass) && strlen($pass) >= 8) {
        $query = "INSERT INTO usuarios (id_usuario, username, nombre, correo, pass) VALUES (NULL, '$username', '$nombre', '$email', '$pass')";
        if (mysqli_query($bd, $query)) {
            header("Location: login.php");
            exit();
        } else {
            $mensaje = "Por favor, vuelve a intentarlo";
        }
    } else {
        $mensaje = "Por favor, completa todos los campos correctamente";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Registrarse</title>
</head>
<body>
    <div class="container">
        <form class="formulario" action="registrarse.php" method="post">
            USERNAME <input type="text" name="username" placeholder="Username" required>
            <br>
            NOMBRE <input type="text" name="nombre" placeholder="Nombre completo" required>
            <br>
            EMAIL <input type="text" name="email" placeholder="Email" required>
            <br>
            PASSWORD <input type="password" name="pass" placeholder="Mínimo 8 caracteres" required>
            <br>
            <input type="submit" value="Registrarse">
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
