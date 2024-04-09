<?php
require_once 'conexion.php';
require_once 'functions.php';

session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $Contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

    if (!empty($Usuario) && !empty($Contrasena)) {
        $sql = "SELECT Id, usuario, contrasena FROM usuarios WHERE usuario = '$Usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($Contrasena === $row['contrasena']) {
                $token = generarToken();
                actualizarToken($row['Id'], $token);

                $_SESSION['token'] = $token;
                header("Location: index.php");
                exit();
            } else {
                $error_message = "usuario o contraseña incorrectos";
            }
        } else {
            $error_message = "usuario o contraseña incorrectos";
        }
    } else {
        $error_message = "favor de completar todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="post" action="">
            <label for="Usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="Contrasenia">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>

            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
