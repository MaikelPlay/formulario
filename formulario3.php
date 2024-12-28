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

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['anterior'])) {
        header("Location: verificar.php");
        exit;
    }

    $nombre_titular = $_POST['nombre_titular'] ?? '';
    $modalidad_pago = $_POST['modalidad_pago'] ?? '';
    $ccc_part1 = $_POST['ccc_part1'] ?? '';
    $ccc_part2 = $_POST['ccc_part2'] ?? '';
    $ccc_part3 = $_POST['ccc_part3'] ?? '';
    $ccc_part4 = $_POST['ccc_part4'] ?? '';
    $numero_tarjeta = $_POST['numero_tarjeta'] ?? '';

    if (empty($nombre_titular)) {
        $errores['nombre_titular'] = "El nombre del titular es obligatorio.";
    }

    if (empty($modalidad_pago)) {
        $errores['modalidad_pago'] = "Debe seleccionar una modalidad de pago.";
    }

    if (empty($ccc_part1) || empty($ccc_part2) || empty($ccc_part3) || empty($ccc_part4)) {
        $errores['ccc'] = "Debe completar el Código Cuenta Cliente.";
    }

    if (empty($numero_tarjeta)) {
        $errores['numero_tarjeta'] = "Debe proporcionar el número de tarjeta.";
    }

    if (empty($errores)) {
        $_SESSION['nombre_titular'] = $nombre_titular;
        $_SESSION['modalidad_pago'] = $modalidad_pago;
        $_SESSION['ccc_part1'] = $ccc_part1;
        $_SESSION['ccc_part2'] = $ccc_part2;
        $_SESSION['ccc_part3'] = $ccc_part3;
        $_SESSION['ccc_part4'] = $ccc_part4;
        $_SESSION['numero_tarjeta'] = $numero_tarjeta;
        header("Location: verificar.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario 3 - Datos de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top: 20px;
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

        .info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
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
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .ccc-group input {
            width: calc(22% - 10px);
            display: inline-block;
            margin-right: 5px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .radio-group {
            margin-top: 10px;
        }

        .radio-group label {
            display: block;
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

        <h1>Formulario de Pago</h1>
        <div class="info">Los campos marcados con <span style="color: red;">*</span> son obligatorios.</div>

        <form method="POST">
            <fieldset>
                <legend>Datos de Pago</legend>

                <label>Nombre del titular <span style="color: red;">*</span>:</label>
                <input type="text" name="nombre_titular" value="<?= htmlspecialchars($_SESSION['nombre_titular'] ?? '') ?>">
                <span class="error"><?= $errores['nombre_titular'] ?? '' ?></span>

                <label>Modalidad de Pago <span style="color: red;">*</span>:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="modalidad_pago" value="Domiciliación bancaria" 
                            <?= (isset($_SESSION['modalidad_pago']) && $_SESSION['modalidad_pago'] === 'Domiciliación bancaria') ? 'checked' : '' ?>>
                        Domiciliación bancaria
                    </label>
                    <label>
                        <input type="radio" name="modalidad_pago" value="Transferencia bancaria" 
                            <?= (isset($_SESSION['modalidad_pago']) && $_SESSION['modalidad_pago'] === 'Transferencia bancaria') ? 'checked' : '' ?>>
                        Transferencia bancaria
                    </label>
                    <label>
                        <input type="radio" name="modalidad_pago" value="Tarjeta de crédito" 
                            <?= (isset($_SESSION['modalidad_pago']) && $_SESSION['modalidad_pago'] === 'Tarjeta de crédito') ? 'checked' : '' ?>>
                        Tarjeta de crédito
                    </label>
                </div>
                <span class="error"><?= $errores['modalidad_pago'] ?? '' ?></span>

                <label>Código Cuenta Cliente (CCC) <span style="color: red;">*</span>:</label>
                <div class="ccc-group">
                    <input type="text" name="ccc_part1" maxlength="4" value="<?= htmlspecialchars($_SESSION['ccc_part1'] ?? '') ?>">
                    <input type="text" name="ccc_part2" maxlength="4" value="<?= htmlspecialchars($_SESSION['ccc_part2'] ?? '') ?>">
                    <input type="text" name="ccc_part3" maxlength="4" value="<?= htmlspecialchars($_SESSION['ccc_part3'] ?? '') ?>">
                    <input type="text" name="ccc_part4" maxlength="4" value="<?= htmlspecialchars($_SESSION['ccc_part4'] ?? '') ?>">
                </div>
                <span class="error"><?= $errores['ccc'] ?? '' ?></span>

                <label>Número de tarjeta:</label>
                <input type="text" name="numero_tarjeta" value="<?= htmlspecialchars($_SESSION['numero_tarjeta'] ?? '') ?>">
                <span class="error"><?= $errores['numero_tarjeta'] ?? '' ?></span>
            </fieldset>

            <button type="submit" name="anterior">Anterior (Datos de Inscripción)</button>
            <button type="submit">Siguiente (Confirmar Inscripción) >> </button>
        </form>
    </div>
</body>
</html>
