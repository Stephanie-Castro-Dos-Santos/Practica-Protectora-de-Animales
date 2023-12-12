<?php
    class Controlador{
        private $modelo;
        private $vista;

    /* ---------------------------------------------------------------------- */

        // Constructor
        public function __construct($mod,$vis){
            $this->modelo=$mod;
            $this->vista=$vis;
        }

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

        //toString
        /*function __toString(){
            return  "<b>USUARIO:</b> <br>". 
                        "ID: ".$this->id . 
                        "<br>Nombre: " . $this->nombre . 
                        "<br>Apellido: " . $this->apellido. 
                        "<br>Sexo: " . $this->sexo . 
                        "<br>Dirección: " . $this->direccion.
                        "<br>Teléfono: " . $this->telefono;
        }*/


        
    }
?>