<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewchetti Secret</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>

        <h1>Jewchetti Secret</h1>

        <?php if (isset($_SESSION["usuario_id"])): ?>

            <p>
                Hola,
                <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
            </p>

            <a href="perfil.php">Mi perfil</a>
            <a href="cerrar_sesion.php">Cerrar sesión</a>

        <?php else: ?>

            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php">Crear cuenta</a>

        <?php endif; ?>

    </header>

    <main>

        <h2>Bienvenido a Jewchetti Secret</h2>

        <!-- Acá va el contenido actual de tu tienda -->

    </main>

</body>

</html>