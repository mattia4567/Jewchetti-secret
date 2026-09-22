<?php

session_start();

require_once "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($email === "" || $password === "") {

        $mensaje = "Completá todos los campos.";

    } else {

        $consulta = $conn->prepare(
            "SELECT id, nombre, email, password FROM usuarios WHERE email = ?"
        );

        $consulta->bind_param("s", $email);
        $consulta->execute();

        $resultado = $consulta->get_result();

        if ($resultado->num_rows === 1) {

            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario["password"])) {

                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["nombre"] = $usuario["nombre"];
                $_SESSION["email"] = $usuario["email"];

                header("Location: index.php");
                exit;

            } else {

                $mensaje = "Contraseña incorrecta.";
            }

        } else {

            $mensaje = "No existe una cuenta con ese email.";
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
    <title>Iniciar sesión - Jewchetti Secret</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <main>

        <h1>Iniciar sesión</h1>

        <?php if (isset($_GET["registro"]) && $_GET["registro"] === "exitoso"): ?>
            <p>Cuenta creada correctamente. Ahora podés iniciar sesión.</p>
        <?php endif; ?>

        <?php if ($mensaje !== ""): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar sesión</button>

        </form>

        <p>
            ¿No tenés una cuenta?
            <a href="registro.php">Crear cuenta</a>
        </p>

    </main>

</body>

</html>