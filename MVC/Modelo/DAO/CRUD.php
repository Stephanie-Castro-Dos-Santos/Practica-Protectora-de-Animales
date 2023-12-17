<?php
    require_once "Conexion.php";

    abstract class CRUD extends Conexion{
        // Atributos de la CLASE Conexión
        private $tabla;
        private $conexion; // metodo realizar conexión
    
    /* ---------------------------------------------------------------------- */
        //Constructor
        public function __construct($tabla){
            $this->tabla = $tabla;
            $this->conexion=parent::realizarConexion();
        }
    
    /* ---------------------------------------------------------------------- */
        //MÉTODOS PÚBLICOS  
        
        //Método que dado un objeto lo insertará en la BBDD 
        public function crear($objeto){
 
            try{

                $consultaPreparada = $this->formarConsultaCrear($objeto); //Consulta preparada

                $consulta = $this->conexion->prepare($consultaPreparada);


                //Dar valor a los parametros de la consulta preparada:
                $propiedades=$objeto->obtenerAtributos();

                foreach($propiedades as $clave => $valor){

                    // Almacenar el valor en una variable
                    $valorAtributo = $objeto->__get($valor);
                    
                    // Pasar la variable por referencia a bindParam
                    $consulta->bindValue(":" . $valor, $valorAtributo);

                }

               $consulta->execute();

                echo "Se ha realizado la inserción con exito";


            }catch (PDOException $e) {
                echo "Fallo: " . $e->getMessage();
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            
        

        }

        
    // En el método actualizar
    public function actualizar($id, $datos_actualizados)
    {
        try {
            // Construir la consulta preparada
            $valoresSet = implode(", ", array_map(fn ($col) => "$col = :$col", array_keys($datos_actualizados)));
            $consultaPreparada = "UPDATE " . $this->tabla . " SET " . $valoresSet . " WHERE id = :id";

            $consulta = $this->conexion->prepare($consultaPreparada);

            // Dar valor a los parámetros de la consulta preparada
            foreach ($datos_actualizados as $col => $valor) {
                $consulta->bindValue(":" . $col, $valor);
            }

            // Asignar el valor del ID
            $consulta->bindValue(":id", $id);

            // Ejecutar la consulta
            $consulta->execute();

            echo "Se ha realizado la actualización con éxito";
        } catch (PDOException $e) {
            echo "Error al actualizar: " . $e->getMessage();
        }
    }


    // Método que devuelve TODOS los registros de la tabla
    public function obtieneTodos(){
        try{
            // 1. Generamos la consulta
            $consulta = $this->conexion->prepare("SELECT * FROM $this->tabla;");
        
            // 2. Ejecutamos la consulta y obtenemos el resultado como un array asociativo
            $consulta->execute();
            $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
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



    public function borrar($id){
        try {
            // Utilizamos una consulta preparada para evitar problemas de seguridad
            $consulta = $this->conexion->prepare("DELETE FROM $this->tabla WHERE id = :id");
            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        
            // Ejecutamos la consulta preparada
            $consulta->execute();
        
            echo "Elemento eliminado con éxito.";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /* ---------------------------------------------------------------------- */

    //MÉTODOS AUXILIARES: 


    //Método auxiliar que se usara dentro de crear, concatenara los atributos del objeto para formar la consulta SQL


    private function formarConsultaCrear($objeto){

        $atributosObjeto = $objeto->obtenerAtributos();//Array asociativo con el nombre de los atributos del objeto y sus valores

        $values="";


        foreach($atributosObjeto as $clave => $valor){

            $values = $values.":".$valor.",";

        }

        $values = substr($values, 0, -1); //Se quita la ultima coma de la cadena


        return "INSERT INTO ".$objeto::TABLA." VALUES({$values});";
       

    }


    public function obtenerTipoLongitud($objeto){

        $consulta = $this->conexion->prepare(
                                                "SELECT DATA_TYPE, CHARACTER_MAXIMUM_LENGTH
                                                FROM information_schema.columns
                                                WHERE TABLE_NAME = '" .$objeto::TABLA. "' AND TABLE_SCHEMA = 'protectora_animales';");

        // Ejecutamos la consulta preparada
        $consulta->execute();

        $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;

    }

    abstract public function obtenerAtributos();

    



}

?>