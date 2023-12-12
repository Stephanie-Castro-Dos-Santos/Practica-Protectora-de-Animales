<?php
    require_once "CRUD.php";

    class Animal extends CRUD{
        private $id;
        private $nombre;
        private $especie;
        private $raza;
        private $genero;
        private $color;
        private $edad;
        private $conexion;
        const TABLA = "animal";

    /* ---------------------------------------------------------------------- */

        // Constructor
        public function __construct($id, $nom, $esp, $raza, $gen, $color, $edad){
            $this->id=$id;
            $this->nombre = $nom;
            $this->especie = $esp;
            $this->raza = $raza;
            $this->genero = $gen;
            $this->color = $color;
            $this->edad = $edad;
            $this->conexion=parent::realizarConexion();
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

    /* ---------------------------------------------------------------------- */
        // MÉTODOS PÚBLICOS - abstractos de la clase PADRE

        public function crear(){

            try{

                // Evitamos el ERROR de duplicidad con ID
                if($this->obtieneDeID($this->id)==false){

                    // 1. Preparamos la consulta de INSERT
                    $consulta=$this->conexion->prepare("INSERT INTO ". self::TABLA ." VALUES (?,?,?,?,?,?,?);");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->nombre);
                    $consulta->bindParam(3, $this->especie);
                    $consulta->bindParam(4, $this->raza);
                    $consulta->bindParam(5, $this->genero);
                    $consulta->bindParam(6, $this->color);
                    $consulta->bindParam(7, $this->edad);
        
                    // 3. Ejecutamos la consulta y obtenemos el resultado
                    $consulta->execute();
                }
                else{
                    echo "El animal ya existe";
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }

        public function actualizar(){

            try{

                $registros=$this->obtieneDeID($this->id);

                if($registros!=false){

                    // 1. Preparamos la consulta de UPDATE
                    $consulta=$this->conexion->prepare("UPDATE " .self::TABLA. " SET id=?,nombre=?,especie=?,raza=?,genero=?,color=?, edad=? WHERE id = ?;");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->nombre);
                    $consulta->bindParam(3, $this->especie);
                    $consulta->bindParam(4, $this->raza);
                    $consulta->bindParam(5, $this->genero);
                    $consulta->bindParam(6, $this->color);
                    $consulta->bindParam(7, $this->edad);
                    $consulta->bindParam(8, $this->id, PDO::PARAM_INT);
        
                    // 3. Ejecutamos la consulta y obtenemos el resultado
                    $consulta->execute();
                }
                else{
                    echo "No se ha encontrado ningún dato que coincida con el parámetro introducido";
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }

    }
?>