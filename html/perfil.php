<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil - Jewchetti Secret</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <main>

        <h1>Mi perfil</h1>

        <p>
            Bienvenido/a,
            <strong>
                <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
            </strong>
        </p>

        <p>
            Email:
            <?php echo htmlspecialchars($_SESSION["email"]); ?>
        </p>

        <a href="index.php">Volver a la tienda</a>

        <br><br>

        <a href="cerrar_sesion.php">Cerrar sesión</a>

    </main>

</body>

</html>