<?php

    if(isset($_REQUEST["controlador"])){
        //Llamamos al CONTROLADOR
        $tabla=$_REQUEST["controlador"];
        $nomControlador=ucfirst($tabla);
        $urlControlador="Controlador/Controlador.php";

        require_once $urlControlador;

        //Llamamos a la VISTA
        $urlVista="Vista/vista_".$tabla.".php";
        
        require_once $urlVista;
    }
    else{
        require_once "Vista/vista_index.php";
    }
    
?>