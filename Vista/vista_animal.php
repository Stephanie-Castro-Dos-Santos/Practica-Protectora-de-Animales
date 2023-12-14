<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal</title>
</head>
<body>
    <h1>TABLA ANIMAL</h1>

    <table>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Especie</th>
            <th>Raza</th>
            <th>Género</th>

        </tr>

        <?php
            $controlador=new Controlador("Animal");
            $controlador->mostrarDatos();
        ?>
    </table>
    
    <button>Nuevo</button>
    
</body>
</html>
