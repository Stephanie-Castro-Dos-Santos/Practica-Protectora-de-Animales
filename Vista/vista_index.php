<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

    <!--FORMULARIO SELECT PARA ELEGIR TABLA-->
    <form name="formulario" method="post" action="index.php">

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

    <table>
        <tr>
            <?php
                    if($columnas!=false && $datos!=false){
                        //Imprimir nombres de columnas
                        foreach($columnas as $columna){
                            echo "<th>".$columna."</th>";
                        }

                        //Imprimir los registros
                        foreach($datos as $dato){
                            echo "<td>".$dato."</td>";
                        }

                    }
            ?>
        </tr>

        <?php

        ?>

    </table>

    
</body>
</html>