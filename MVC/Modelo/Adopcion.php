<?php 
    require_once "DAO/CRUD.php";

    class Adopcion extends CRUD{
        private $id;
        private $idAnimal;
        private $idUsuario;
        private $fecha;
        private $razon;
        //private $conexion;
        const TABLA = "adopcion";

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
            return  "<b>USUARIO:</b> <br>". 
                        "ID: ".$this->id . 
                        "<br>ID Animal: " . $this->id_Animal . 
                        "<br>ID Usuario: " . $this->id_Usuario. 
                        "<br>Fecha: " . $this->fecha . 
                        "<br>Razón: " . $this->razon;
        }

        public function obtenerAtributos(){
            $propiedades = get_object_vars($this);
            return array_keys($propiedades);
        }

    }
?>