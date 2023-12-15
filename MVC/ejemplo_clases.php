<?php
    require_once "Clases/Usuario.php";
    require_once "Clases/Animal.php";
    require_once "Clases/Adopcion.php";

/* ---------------------------------------------------------------------- */
    
    echo "<h3>USUARIOS</h3>";

    // 1. Generamos los OBJETOS tipo USUARIO
    $user1 = new Usuario (7,"Stephanie","Castro","Femenino","Av. Castilla y León 9","+34 611443093");
    $user2 = new Usuario (8,"Carlos","Castro","Masculino","Av. Castilla y León 9","+34 611443093");
    $user3 = new Usuario (9,"Delia","Dos Santos","Femenino","Av. Castilla y León 9","+34 653745971");

    // 1.1 Lo introducimos en un array
    $usuarios=[$user1,$user2,$user3];

    // 1.2 Imprimimos los USUARIOS
    imprimir($usuarios);

    // 1.3 Tenemos la condición para evitar el mensaje de ERROR --> EVITAR crear otra vez el USUARIO tras refrescar
    comprobacionCrear($usuarios);

    // 2. Actualizamos un USUARIO
    // EXPLICACIÓN: Modificamos el USUARIO para luego hacerlo con la BBDD 
    $user2->__set("telefono","+34 611443096");
    $user2->actualizar();

    imprimir($usuarios);

    // 3. Borramos un USUARIO
    $user3->borrar($user3->__get("id"));

    echo "<hr>";
/* ---------------------------------------------------------------------- */

    echo "<h3>ANIMALES</h3>";

    // 1. Generamos los OBJETOS tipo ANIMAL
    $animal1 = new Animal(10, "Linda", "perro", "Golden Retriever", "Macho", "Dorado", 5);
    $animal2 = new Animal(4, "Queen", "perro", "Bichón Maltés", "Hembra", "Blanco", 4);
    $animal3 = new Animal(5, "Pelusa", "gato", "Mezcla", "Macho", "Naranja", 2);

    $animales=[$animal1,$animal2,$animal3];

    imprimir($animales);

    comprobacionCrear($animales);

    // 2. Actualizamos un ANIMAL
    // EXPLICACIÓN: Modificamos el ANIMAL para luego hacerlo con la BBDD 
    $animal2->__set("edad",3);
    $animal2->actualizar();

    // 3. Borramos un ANIMAL
    $animal3->borrar($animal3->__get("id"));

    echo "<hr>";

    /* ---------------------------------------------------------------------- */
    
    echo "<h3>ADOPCIONES</h3>";

    // 1. Generamos los OBJETOS tipo ANIMAL
    $adopcion1 = new Adopcion(10, 3, 7, "2023-12-24", "Regalo de Navidad");
    $adopcion2 = new Adopcion(5, 5, 8, "2023-4-5", "Regalo de cumpleaños");
    $adopcion3 = new Adopcion(8, 10, 6, "2022-4-12", "Regalo para la familia");

    $adopciones=[$adopcion1,$adopcion2,$adopcion3];

    imprimir($adopciones);

    comprobacionCrear($adopciones);

        // 2. Actualizamos un ANIMAL
    // EXPLICACIÓN: Modificamos el ANIMAL para luego hacerlo con la BBDD 
    $adopcion2->__set("idAnimal",4);
    $adopcion2->actualizar();

    // 3. Borramos un ANIMAL
    $adopcion3->borrar($adopcion3->__get("id"));

    echo "<hr>";

    get_object_vars($adopcion1);


    /* ---------------------------------------------------------------------- */
    // FUNCIONES
    function imprimir($array) {
        foreach($array as $elemento){
            echo "<p>".$elemento."</p>";
        }
    }

    function comprobacionCrear($array){
        foreach($array as $objeto){
            $objeto->crear();
        }
    }

?>