<?php
    require_once "Conexion.php";

    abstract class CRUD extends Conexion{
        // Atributos de la CLASE Conexión
        private $tabla;
        private $conexion; // metodo realizar conexión
    
    /* ---------------------------------------------------------------------- */
        //Constructor
        public function __construct($tabla){
            $this->tabla=$tabla;
            $this->conexion=parent::realizarConexion();
        }
    
    /* ---------------------------------------------------------------------- */
        //MÉTODOS PÚBLICOS

        // Método que devuelve TODOS los registros de la tabla
        public function obtieneTodos(){
            try{

                // 1. Generamos la consulta
                $consulta=$this->conexion->prepare("SELECT * FROM $this->tabla;");
    
                // 2. Ejecutamos la consulta y obtenemos el resultado
                $consulta->execute();
    
                // 3. Recuperamos los registros pero como un OBJETO
                $registros=$consulta->fetchAll(PDO::FETCH_OBJ);
    
                return $registros;
                
            }
            catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }
        }

        // Método que devuelve el resultado que coincida con el ID de la tabla seleccionada
        public function obtieneDeID($id){
            try{

                // 1. Generamos la consulta
                $consulta=$this->conexion->prepare("SELECT * FROM $this->tabla WHERE id=?;");
    
                // 2. Como parámetro pasamos el ID
                $consulta->bindParam(1, $id);
    
                // 3. Ejecutamos la consulta y obtenemos el resultado
                $consulta->execute();
    
                // 4. Recuperamos los registros pero como un OBJETO
                $registros=$consulta->fetch(PDO::FETCH_OBJ);
    
                return $registros;

            }
            catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }
        }

        // Método para borrar un elemento de la tabla cuando coincida el ID
        public function borrar($id){
            try{
                $registros=$this->obtieneDeID($id);

                if($registros!=false){
                    // 1. Generamos la consulta
                    $consulta = $this->conexion->prepare("DELETE FROM $this->tabla WHERE id=?;");
    
                    // 2. Como parámetro pasamos el ID
                    $consulta->bindParam(1, $id);
    
                    // 3. Ejecutamos la consulta y obtenemos el resultado
                    $consulta->execute();
    
                    //Mensaje
                    echo "<p class='correct'>Se ha eliminado correctamente</p>"; 
    
                }
                else{
                    echo "No se puede eliminar porque no existe";
                }
            }
            catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }
        }

    /* ---------------------------------------------------------------------- */
        // MÉTODOS ABSTRACTOS
        abstract function crear();
        abstract function actualizar();

    }

?>