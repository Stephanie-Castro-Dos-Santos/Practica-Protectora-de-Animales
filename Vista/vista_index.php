<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

    <!--FORMULARIO SELECT PARA ELEGIR TABLA-->
    <form name="formulario" method="post" action="">

        <select name="tablas">
            <legend>Selecciona la tabla</legend>

            <option value="1">Usuario</option>
            <option value="2">Animal</option>
            <option value="3">Adopción</option>
        
        </select>

        <br>
        <br/>
        <input type="submit" name="botonEnviar" value="Mostrar" />
    </form>

    <button>Añadir</button> <!-- Redirección a la VISTA (INSERT) -->
    <button>Modificar</button> <!-- Redirección a la VISTA (UPDATE) -->
    <button>Borrar</button> <!-- Redirección a la VISTA (BORRAR) -->

    <?php
        if(isset($_POST["botonEnviar"])){
            //get_object_vars($this) : array
            $elemento;

            switch((int)$_POST["tablas"]){
                case 1:
                    $elemento=new Usuario();
                    break;

                case 2:
                    $elemento=new Animal();
                    break;

                case 3:
                    $elemento=new Adopcion();
                    break;
            }

            $columnas=get_object_vars($elemento);
        }
    ?>
    
</body>
</html>