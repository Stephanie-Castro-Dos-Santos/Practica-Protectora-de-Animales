<?php

    if(isset($_REQUEST["controlador"])){
        //Llamamos al CONTROLADOR
        require_once "Controlador/Controlador.php";

        $controlador=new Controlador();
        $url="Vista/".$_REQUEST["controlador"].".php";
        require_once $url;
    }
    else{
        require_once "Vista/vista_index.php";
    }
?>