<?php

require_once "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmar_password = $_POST["confirmar_password"];

    if ($nombre === "" || $email === "" || $password === "" || $confirmar_password === "") {

        $mensaje = "Completá todos los campos.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresá un email válido.";

    } elseif ($password !== $confirmar_password) {

        $mensaje = "Las contraseñas no coinciden.";

    } else {

        $consulta = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {

            $mensaje = "Ese email ya está registrado.";

        } else {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $insertar = $conn->prepare(
                "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)"
            );

            $insertar->bind_param("sss", $nombre, $email, $password_hash);

            if ($insertar->execute()) {

                header("Location: login.php?registro=exitoso");
                exit;

            } else {

                $mensaje = "Ocurrió un error al crear la cuenta.";
            }

            $insertar->close();
        }

        $consulta->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Jewchetti Secret</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <main>

        <h1>Crear cuenta</h1>

        <?php if ($mensaje !== ""): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <form method="POST" action="registro.php">

            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <label>Confirmar contraseña</label>
            <input type="password" name="confirmar_password" required>

            <button type="submit">Crear cuenta</button>

        </form>

        <p>
            ¿Ya tenés una cuenta?
            <a href="login.php">Iniciar sesión</a>
        </p>

    </main>

</body>

</html>