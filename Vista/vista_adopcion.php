<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopcion</title>
</head>
<body>
    <h1>TABLA ADOPCIÓN</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>ID_Animal</th>
            <th>ID_Usuario</th>
            <th>Fecha</th>
            <th>Razón</th>
        </tr>

        <?php
            $controlador=new Controlador("Adopcion");
            $controlador->mostrarDatos();
        ?>
    </table>

    <button>Nuevo</button>

</body>
</html>
