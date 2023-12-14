<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <form method="post" action="">
        <?php
            if(isset($_REQUEST["controlador"])){
                $controlador=$_REQUEST["controlador"];
                $controlador->propiedades();
            }

        ?>

        <input type="submit" name="botonEnviar" value="Crear" >
    </form>
    
</body>
</html>