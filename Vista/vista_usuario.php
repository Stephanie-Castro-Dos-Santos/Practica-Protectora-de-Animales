<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Usuario</title>
</head>
<body>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Sexo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php

            $controlador=new Controlador("Usuario");
            $controlador->mostrarDatos();

             // Acción al hacer clic en el botón "Eliminar"
             if (isset($_POST['eliminar_elemento'])) {
                $id_elemento = $_POST['id_elemento'];
                $controlador->eliminarElemento($id_elemento);
            }
        ?>
</table>


<button onclick="window.location='Vista/vista_form.php?controlador=$controlador'">Nuevo</button>

    
</body>
</html>
