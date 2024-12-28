<?php
session_start();

if (isset($_COOKIE['inicio_registro'])) {
    $tiempo_transcurrido = time() - $_COOKIE['inicio_registro'];

    if ($tiempo_transcurrido > 60) {
        setcookie('inicio_registro', '', time() - 3600, '/');

        header("Location: formulario1.php?error=tiempo_excedido");
        exit;
    }
}

if (!isset($_COOKIE['inicio_registro'])) {
    setcookie('inicio_registro', time(), time() + 3600, '/');
}

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $pais = $_POST['pais'] ?? '';

    if (empty($nombre)) {
        $errores['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($apellidos)) {
        $errores['apellidos'] = "Los apellidos son obligatorios.";
    }
    if (empty($email)) {
        $errores['email'] = "El correo electrónico es obligatorio.";
    }
    if (empty($telefono)) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    }

    if (empty($errores)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['email'] = $email;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['cargo'] = $cargo;
        $_SESSION['provincia'] = $provincia;
        $_SESSION['pais'] = $pais;

        header("Location: formulario2.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario 1 - Datos Personales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top:75px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        fieldset {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
        }

        legend {
            font-weight: bold;
            color: #555;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .info span {
            color: red;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 15px;
                width: 100%;
                max-width: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'tiempo_excedido'): ?>
            <div class="error-message">Ha excedido el tiempo límite. Por favor, reinicie el proceso desde el principio.</div>
        <?php endif; ?>

        <h1>Formulario de Registro</h1>
        <div class="info">Los campos marcados con <span>*</span> son obligatorios.</div>

        <form method="POST">
            <fieldset>
                <legend>Datos de la Persona a Inscribir</legend>

                <label>Nombre <span>*</span>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($_SESSION['nombre'] ?? '') ?>">
                    <span class="error"><?= $errores['nombre'] ?? '' ?></span>
                </label>

                <label>Apellidos <span>*</span>
                    <input type="text" name="apellidos" value="<?= htmlspecialchars($_SESSION['apellidos'] ?? '') ?>">
                    <span class="error"><?= $errores['apellidos'] ?? '' ?></span>
                </label>

                <label>Correo Electrónico <span>*</span>
                    <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">
                    <span class="error"><?= $errores['email'] ?? '' ?></span>
                </label>

                <label>Teléfono <span>*</span>
                    <input type="text" name="telefono" value="<?= htmlspecialchars($_SESSION['telefono'] ?? '') ?>">
                    <span class="error"><?= $errores['telefono'] ?? '' ?></span>
                </label>

                <label>Cargo
                    <input type="text" name="cargo" value="<?= htmlspecialchars($_SESSION['cargo'] ?? '') ?>">
                </label>

                <label>Provincia
                    <input type="text" name="provincia" value="<?= htmlspecialchars($_SESSION['provincia'] ?? '') ?>">
                </label>

                <label>País
                    <input type="text" name="pais" value="<?= htmlspecialchars($_SESSION['pais'] ?? '') ?>">
                </label>
            </fieldset>

            <button type="submit">Siguiente (Datos de Inscripción) >></button>
        </form>
    </div>
</body>
</html>
