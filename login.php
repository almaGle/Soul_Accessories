<?php
include("conexion.php");

$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valoruser = $_POST["username"];
    $valorpass = $_POST["pass"];

    // Verifica la conexión a la base de datos
    if ($bd->connect_error) {
        die("Connection failed: " . $bd->connect_error);
    }

    // Prepara la consulta para prevenir inyecciones SQL
    $stmt = $bd->prepare("SELECT id_usuario FROM usuarios WHERE username = ? AND pass = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($bd->error));
    }

    $stmt->bind_param("ss", $valoruser, $valorpass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $fila = $result->fetch_assoc();
        header("Location: productos.php?id_usuario=" . $fila['id_usuario']);
        exit(); // Asegúrate de que no haya ninguna otra salida después de la redirección
    } else {
        $mensaje_error = "Revisa tu usuario y contraseña";
        header("Location: login.php?error=" . urlencode($mensaje_error));
        exit();
    }

    $stmt->close();
}

// Mostrar el mensaje de error si existe
if (isset($_GET['error'])) {
    $mensaje_error = htmlspecialchars($_GET['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <form class="formulario" action="login.php" method="post">
            USERNAME <input type="text" name="username" placeholder="Username" required>
            <br>
            PASSWORD <input type="password" name="pass" placeholder="Mínimo 8 caracteres" required>
            <br>
            <input type="submit" value="Iniciar sesión">
            <a href="registrarse.php">Regístrate</a>
            <a href="recuperarPass.php">Olvidé mi contraseña</a>
        </form>

        <?php 
        if ($mensaje_error != "") {
            echo "<p style='color:red;'>$mensaje_error</p>";
        }
        ?>
    </div>
    <footer>
        <img src="instagram.png"> <!-- Reemplaza "soul_logo.png" con la ruta de tu imagen -->
        <p><a href="https://www.instagram.com/soul_accessori">Soul Accesories</a></p>
    </footer>
</body>
</html>
