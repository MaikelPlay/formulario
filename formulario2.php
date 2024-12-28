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
        header("Location: formulario3.php");
        exit;
    }

    $modalidad = $_POST['modalidad'] ?? '';
    $codigo_descuento = $_POST['codigo_descuento'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';

    if (empty($modalidad)) {
        $errores['modalidad'] = "Debe seleccionar una modalidad de inscripción.";
    }

    if (empty($errores)) {
        $_SESSION['modalidad'] = $modalidad;
        $_SESSION['codigo_descuento'] = $codigo_descuento;
        $_SESSION['observaciones'] = $observaciones;

        header("Location: formulario3.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario 2 - Datos de Inscripción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin-top:50px;
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

        .info {
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
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

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        .radio-group {
            margin-top: 10px;
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

        <h1>Formulario de Inscripción</h1>
        <div class="info">Los campos marcados con <span style="color: red;">*</span> son obligatorios.</div>

        <form method="POST">
            <fieldset>
                <legend>Datos de la Inscripción</legend>

                <label>Modalidad de Inscripción <span style="color: red;">*</span></label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="modalidad" value="ANULACIÓN DE INSCRIPCIÓN (0 €)" 
                            <?= (isset($_SESSION['modalidad']) && $_SESSION['modalidad'] === 'ANULACIÓN DE INSCRIPCIÓN (0 €)') ? 'checked' : '' ?>>
                        ANULACIÓN DE INSCRIPCIÓN (0 €)
                    </label>
                    <label>
                        <input type="radio" name="modalidad" value="2 Días de Conferencias (150.8 €)" 
                            <?= (isset($_SESSION['modalidad']) && $_SESSION['modalidad'] === '2 Días de Conferencias (150.8 €)') ? 'checked' : '' ?>>
                        2 Días de Conferencias (150.8 €)
                    </label>
                    <label>
                        <input type="radio" name="modalidad" value="2 Días de Conferencias + Certificado (168.2 €)" 
                            <?= (isset($_SESSION['modalidad']) && $_SESSION['modalidad'] === '2 Días de Conferencias + Certificado (168.2 €)') ? 'checked' : '' ?>>
                        2 Días de Conferencias + Certificado (168.2 €)
                    </label>
                    <label>
                        <input type="radio" name="modalidad" value="2 Días de Conferencias + Tutorial (325.96 €)" 
                            <?= (isset($_SESSION['modalidad']) && $_SESSION['modalidad'] === '2 Días de Conferencias + Tutorial (325.96 €)') ? 'checked' : '' ?>>
                        2 Días de Conferencias + Tutorial (325.96 €)
                    </label>
                    <label>
                        <input type="radio" name="modalidad" value="2 Días de Conferencias + Tutorial + Certificado (343.36 €)" 
                            <?= (isset($_SESSION['modalidad']) && $_SESSION['modalidad'] === '2 Días de Conferencias + Tutorial + Certificado (343.36 €)') ? 'checked' : '' ?>>
                        2 Días de Conferencias + Tutorial + Certificado (343.36 €)
                    </label>
                    <span class="error"><?= $errores['modalidad'] ?? '' ?></span>
                </div>

                <label>Código de Descuento:
                    <input type="text" name="codigo_descuento" value="<?= htmlspecialchars($_SESSION['codigo_descuento'] ?? '') ?>">
                </label>

                <label>Observaciones:
                    <textarea name="observaciones"><?= htmlspecialchars($_SESSION['observaciones'] ?? '') ?></textarea>
                </label>
            </fieldset>

            <button type="submit" name="anterior">Anterior (Datos Personales)</button>
            <button type="submit">Siguiente (Datos de Pago) >></button>
        </form>
    </div>
</body>
</html>
