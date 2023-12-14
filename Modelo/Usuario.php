<?php 
    require_once "CRUD.php";

    class Usuario extends CRUD{
        private $id;
        private $nombre;
        private $apellido;
        private $sexo;
        private $direccion;
        private $telefono;
        private $conexion;
        const TABLA = "usuarios";

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
                        "<br>Nombre: " . $this->nombre . 
                        "<br>Apellido: " . $this->apellido. 
                        "<br>Sexo: " . $this->sexo . 
                        "<br>Dirección: " . $this->direccion.
                        "<br>Teléfono: " . $this->telefono;
        }

    /* ---------------------------------------------------------------------- */
        // MÉTODOS PÚBLICOS - abstractos de la clase PADRE

        public function crear(){

            try{

                // Evitamos el ERROR de duplicidad con ID
                if($this->obtieneDeID($this->id)==false){
                    // 1. Preparamos la consulta de INSERT
                    $consulta=$this->conexion->prepare("INSERT INTO ". self::TABLA ." VALUES (?,?,?,?,?,?);");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->nombre);
                    $consulta->bindParam(3, $this->apellido);
                    $consulta->bindParam(4, $this->sexo);
                    $consulta->bindParam(5, $this->direccion);
                    $consulta->bindParam(6, $this->telefono);
        
                    // 3. Ejecutamos la consulta y obtenemos el resultado
                    $consulta->execute();
                }
                else{
                    echo "El usuario ya existe <br>";
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
                    $consulta=$this->conexion->prepare("UPDATE " .self::TABLA. " SET id=?,nombre=?,apellido=?,sexo=?,direccion=?,telefono=? WHERE id = ?;");
        
                    // 2. Como parámetro pasamos los valores del OBJETO
                    $consulta->bindParam(1, $this->id, PDO::PARAM_INT); 
                    $consulta->bindParam(2, $this->nombre);
                    $consulta->bindParam(3, $this->apellido);
                    $consulta->bindParam(4, $this->sexo);
                    $consulta->bindParam(5, $this->direccion);
                    $consulta->bindParam(6, $this->telefono);
                    $consulta->bindParam(7, $this->id, PDO::PARAM_INT);
        
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