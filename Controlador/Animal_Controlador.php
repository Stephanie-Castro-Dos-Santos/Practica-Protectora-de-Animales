<?php
    require_once "Modelo/Animal.php";

    class Animal_Controlador{

        //CONSTRUCTOR
        public function __construct(){
            //Creamos variable USUARIO que serpo USUARIO
            $this->animal = new Animal();
        }

        //Función pública que nos permite mostrar los usuarios de la tabla USUARIO
        public function mostrarAnimales(){
           
          $animales = $this->animal->obtieneTodos(); 
    
            foreach ($animales as $animal) {
            //$this->usuario se convierte en una propiedad de la clase y permite accede   

                echo "<tr>";

                foreach($animal as $key => $value) {
                    echo "<td>{$value}</td>";
                }

                echo "</tr>";
            }
        }
    }
?>