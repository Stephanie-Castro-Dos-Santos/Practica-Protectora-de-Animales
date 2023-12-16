<?php
    //Iniciamos una session
    session_start();

    if(isset($_REQUEST["controlador"])){
        /*-----------------------ASIGNAR VARIABLES------------------------------*/
        //Obtenemos las variables de la URL
        //TABLA
        $tabla=$_REQUEST["controlador"];
        $tabla=ucfirst($tabla);

        //Crear los variables de SESSION
        $_SESSION["tabla"]=$tabla;

        /*-----------------------CARGAMOS CONTROLADOR------------------------------*/

        //Llamamos al CONTROLADOR
        require_once "Controlador/Controlador.php";

        //Instanciamos la clase CONTROLADOR
        $controlador=new Controlador($tabla);

        /*-----------------------CARGAMOS VISTAS------------------------------*/
        //Llamamos a la VISTA
        require_once "Vista/vista_general_tablas.php";

    }
    else{
        require_once "Vista/vista_index.php";
    }
    
?>