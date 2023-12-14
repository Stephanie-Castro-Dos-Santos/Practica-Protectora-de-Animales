<?php
    require_once "Modelo/Usuario.php";
    require_once "Modelo/Adopcion.php";
    require_once "Modelo/Animal.php"; 

    class Adopcion_Controlador{

        private $usuario;
        private $adopcion;
        private $animal;

       public function __construct(){
            $this->animal=new Animal();
            $this->usuario=new Usuario();
            $this->adopcion=new Adopcion();
       }

       public function mostrarAdopciones(){
           
        $adopciones = $this->adopcion->obtieneTodos(); 
    
        foreach ($adopciones as $adopcion) {
            /*echo "<tr>";

            // Obtener información del usuario
            $usuario = $this->usuario->obtieneDeID($adopcion->id_usuario);
            echo "<td>{$usuario->nombre} {$usuario->apellido}</td>";

            // Obtener información del animal
            $animal = $this->animal->obtieneDeID($adopcion->id_animal);
            echo "<td>{$animal->nombre}</td>";

            // echo "<td>{$adopcion->otroCampo}</td>";

            echo "</tr>";*/

            echo "<tr>";

                foreach($adopcion as $key => $value) {
                    echo "<td>{$value}</td>";
                }

                echo "</tr>";

        }
       }
       
    }
?>
