<?php
session_start();

if (!isset($_COOKIE['inicio_registro'])) {
    setcookie('inicio_registro', time(), time() + 3600, '/');
} else {
    $tiempo_transcurrido = time() - $_COOKIE['inicio_registro'];
    if ($tiempo_transcurrido > 60) {
        setcookie('inicio_registro', '', time() - 3600, '/');
        session_destroy();
        header("Location: formulario1.php?error=tiempo_excedido");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['anterior'])) {
        header("Location: formulario3.php");
        exit;
    }

    setcookie('inicio_registro', '', time() - 3600, '/');
    header("Location: formulario1.php?mensaje=registro_completado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Inscripción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top: 145px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        fieldset {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
            color: #555;
        }

        .data-row {
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
        }

        .data-label {
            font-weight: bold;
            color: #444;
        }

        .data-value {
            color: #555;
        }

        .actions {
            text-align: center;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 200px; /* Same width for all buttons */
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        button:hover {
            background-color: #45a049;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px; /* Space between buttons */
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 15px;
                width: 100%;
                max-width: 100%;
            }

            button {
                width: 100%; /* Buttons will be full-width on small screens */
                margin: 10px 0; /* Adjust margin for mobile screens */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'tiempo_excedido'): ?>
            <div class="error-message">Error: Ha excedido el tiempo límite para completar el registro. Por favor, reinicie el proceso.</div>
        <?php endif; ?>

        <h1>Confirmación de Inscripción</h1>
        <div class="info">Revise los datos a continuación y confirme la inscripción.</div>

        <fieldset>
            <legend>Datos de la Persona a Inscribir</legend>
            <div class="data-row">
                <span class="data-label">Nombre:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['nombre'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Apellidos:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['apellidos'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Correo Electrónico:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['email'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Teléfono:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['telefono'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Cargo:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['cargo'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Provincia:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['provincia'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">País:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['pais'] ?? 'No proporcionado') ?></span>
            </div>
        </fieldset>

        <fieldset>
            <legend>Datos de la Inscripción</legend>
            <div class="data-row">
                <span class="data-label">Modalidad de Inscripción:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['modalidad'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Código de Descuento:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['codigo_descuento'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Observaciones:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['observaciones'] ?? 'No proporcionado') ?></span>
            </div>
        </fieldset>

        <fieldset>
            <legend>Datos de Pago</legend>
            <div class="data-row">
                <span class="data-label">Nombre del Titular:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['nombre_titular'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Modalidad de Pago:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['modalidad_pago'] ?? 'No proporcionado') ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Código Cuenta Cliente:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['ccc_part1'] . '-' . $_SESSION['ccc_part2'] . '-' . $_SESSION['ccc_part3'] . '-' . $_SESSION['ccc_part4']) ?></span>
            </div>
            <div class="data-row">
                <span class="data-label">Número de Tarjeta:</span>
                <span class="data-value"><?= htmlspecialchars($_SESSION['numero_tarjeta'] ?? 'No proporcionado') ?></span>
            </div>
        </fieldset>

        <div class="buttons-container">
            <form method="POST">
                <button type="submit" name="anterior">Anterior</button>
                <button type="submit" name="enviar">Enviar Inscripción</button>
            </form>
        </div>
    </div>
</body>
</html>
