<?php 
    require_once "DAO/CRUD.php";

    class Adopcion extends CRUD{
        private $id;
        private $idAnimal;
        private $idUsuario;
        private $fecha;
        private $razon;
        private $conexion;
        const TABLA = "adopcion";

    /* ---------------------------------------------------------------------- */

        // Constructor
        public function __construct(){
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
            return  "<b>USUARIO:</b> <br>". 
                        "ID: ".$this->id . 
                        "<br>ID Animal: " . $this->idAnimal . 
                        "<br>ID Usuario: " . $this->idUsuario. 
                        "<br>Fecha: " . $this->fecha . 
                        "<br>Razón: " . $this->razon;
        }

        public function obtenerAtributos(){
            return get_object_vars($this);
        }

    /* ---------------------------------------------------------------------- */
        // MÉTODOS PÚBLICOS - abstractos de la clase PADRE

        /*public function crear(){

            try{

                // Evitamos el ERROR de duplicidad con ID
                if($this->obtieneDeID($this->id)==false){
                    // 1. Preparamos la consulta de INSERT
                    $consulta=$this->conexion->prepare("INSERT INTO ". self::TABLA ." VALUES (?,?,?,?,?);");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->idAnimal);
                    $consulta->bindParam(3, $this->idUsuario);
                    $consulta->bindParam(4, $this->fecha);
                    $consulta->bindParam(5, $this->razon);
        
                    // 3. Ejecutamos la consulta y obtenemos el resultado
                    $consulta->execute();
                }
                else{
                    echo "La adopción ya existe <br>";
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
                    $consulta=$this->conexion->prepare("UPDATE " .self::TABLA. " SET id=?,idAnimal=?,idUsuario=?,fecha=?,razon=? WHERE id = ?;");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->idAnimal);
                    $consulta->bindParam(3, $this->idUsuario);
                    $consulta->bindParam(4, $this->fecha);
                    $consulta->bindParam(5, $this->razon);
                    $consulta->bindParam(6, $this->id, PDO::PARAM_INT);
        
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

        }*/

    }
?>