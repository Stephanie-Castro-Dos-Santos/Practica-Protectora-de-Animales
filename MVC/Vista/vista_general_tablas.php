<?php
    $controlador->crearElemento();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopcion</title>
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
              /*   $controlador->eliminarElemento(); */
            ?>


        </table>
    </form>

    <button onclick="window.location='index.php'">Atrás</button>

</body>
</html>