<?php
    require_once "DAO/CRUD.php";

    class Animal extends CRUD{
        private $id;
        private $nombre;
        private $especie;
        private $raza;
        private $genero;
        private $color;
        private $edad;
        //private $conexion;
        const TABLA = "animal";

    /* ---------------------------------------------------------------------- */

        // Constructor
        public function __construct(){
            //$this->conexion=parent::realizarConexion();
            parent::__construct(self::TABLA);
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
        function __toString(){
            return  "<b>ANIMAL:</b> <br>". 
                        "ID: ".$this->id . 
                        "<br>Nombre: " . $this->nombre . 
                        "<br>Especie: " . $this->especie. 
                        "<br>Raza: " . $this->raza . 
                        "<br>Género: " . $this->genero.
                        "<br>Color: " . $this->color.
                        "<br>Edad: " . $this->edad;
        }

        public function obtenerAtributos(){
            $propiedades = get_object_vars($this);
            return array_keys($propiedades);
        }

    }
?>