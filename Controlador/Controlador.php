<?php
    //Llamadas a las clases del MODELO
    require_once "Modelo/Adopcion.php";
    require_once "Modelo/Animal.php";
    require_once "Modelo/Usuario.php";

    class Controlador{
        private $modelo;
        private $vista;

    /* ---------------------------------------------------------------------- */

        // Constructor
        /*public function __construct($mod,$vis){
            $this->modelo=$mod;
            $this->vista=$vis;
        }*/

    /* ---------------------------------------------------------------------- */
        // MÉTODOS MÁGICOS

        //__get()
        function __get($propiedad){
            if(property_exists($this, $propiedad)) {
                return $this->$propiedad;
            }
        }

        //__set()
        function __set($propiedad,$valor){
            if(property_exists($this, $propiedad)) {
                return $this->$propiedad=$valor;
            }
        }

        public function cont_index(){

            //VARIABLES
            $columnas;
            $datos;

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
                $datos=$elemento->obtieneTodos;
            }
            else{
                $columnas=false;
                $datos=false;
            }

            
            //Llamada a la VISTA del index tras obtener los resultados
            require_once "Vista/vista_index.php";


        }

        public function cont_actualizar(){

        }


        
    }
?>