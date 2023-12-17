<?php
    // Comprobar si el formulario ha sido enviado
    if (isset($_POST["crear_elemento"])) {
        // Validar y procesar los datos POST
        $controlador->crearElemento();
    }
    elseif(isset($_POST["modificar_elemento"])){
        $controlador->actualizarElemento();
    }
    elseif(isset($_POST["eliminar_elemento"])){
        $controlador->eliminarElemento();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/styles.css">
    <title><?php echo $_SESSION["tabla"] ?></title>
</head>
<body>

    <h1>TABLA <?php echo $_SESSION["tabla"] ?></h1>

    <form method="post" action="">
        <table>
            <tr>

                <?php
                    $controlador->mostrarColumnas();
                ?>

            </tr>

            <?php
                $controlador->mostrarDatos();
                $controlador->mostrarCrear();
            ?>


        </table>
    </form>

    <button onclick="window.location='index.php'">Atrás</button>

    <script>
        window.history.replaceState(null, null, window.location.href);
    </script>

</body>
</html>