<?php 
    require_once "DAO/CRUD.php";

    class Usuario extends CRUD{
        private $id;
        private $nombre;
        private $apellido;
        private $sexo;
        private $direccion;
        private $telefono;
        //private $conexion;
        const TABLA = "usuarios";

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
                        "<br>Nombre: " . $this->nombre . 
                        "<br>Apellido: " . $this->apellido. 
                        "<br>Sexo: " . $this->sexo . 
                        "<br>Dirección: " . $this->direccion.
                        "<br>Teléfono: " . $this->telefono;
        }

        public function obtenerAtributos(){
            $propiedades = get_object_vars($this);
            return array_keys($propiedades);
        }

    }
?>