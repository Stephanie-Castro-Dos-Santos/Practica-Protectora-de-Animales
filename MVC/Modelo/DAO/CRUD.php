<?php
    require_once "Conexion.php";

    class CRUD extends Conexion{
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
            
        

        }

        public function actualizar($objeto){

            if(sizeof($this->devolverColsDistintos($objeto))==0) echo "No se puede actualizar porque no se modifico ningun campo";
            else{
            //Array con las columnas que han sido cambiadas por el usuario
           $colsModificadas = $this->devolverColsDistintos($objeto);
       

           //Concatenar estas columnas para la consulta preparada:
            $valoresSet="";
           foreach($colsModificadas AS $col){
            $valoresSet = $valoresSet." ".$col." = :".$col.",";
           }
           $valoresSet = substr($valoresSet, 0, -1); //Se quita la ultima coma de la cadena

           $consultaPreparada= "Update ".$objeto::TABLA. " SET ".$valoresSet." where id=".$objeto->id;

           try{
           $consulta = $this->conexion->prepare($consultaPreparada);


            //Dar valor a los parametros de la consulta preparada:
            foreach($colsModificadas as $col){

                $consulta->bindValue(":".$col,$objeto->$col);

            }
            

           $consulta->execute();

            echo "Se ha realizado la actualización con exito";


        }catch (PDOException $e) {
            echo "Fallo: " . $e->getMessage();
        }
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

        // Método para borrar un elemento de la tabla cuando coincida el ID
       /*  public function borrar($id){
            try{
                $consulta = $this->conexion->query("DELETE FROM $this->tabla WHERE id=$id;");

                echo "Se elimino con exito";
            }
            catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }
        } */

        public function borrar($id){
            /*  try { */
                 // Utilizamos una consulta preparada para evitar problemas de seguridad
                 $consulta = $this->conexion->prepare("DELETE FROM $this->tabla WHERE id = :id");
                 $consulta->bindParam(":id", $id, PDO::PARAM_INT);
         
                 // Ejecutamos la consulta preparada
                 $consulta->execute();
         
               /*   echo "Elemento eliminado con éxito.";
             } catch(PDOException $e) {
                 echo "Error: " . $e->getMessage();
             } */
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

    //Funcion auxiliar para Actualizar, devolvera el nombre de las columnas que han sido modificadas
    private function devolverColsDistintos($objeto){

        $atributosObjeto = $objeto->obtenerAtributos();//Array asociativo con el nombre de los atributos del objeto y sus valores
        try{
                $consulta = "SELECT * FROM ". $objeto::TABLA ." WHERE id = $objeto->id ";
                $resultado = $this->conexion->query($consulta);

                $fila = $resultado->fetch(PDO::FETCH_ASSOC);
                $nombreColumnasCambiadas = [];
                
                foreach ($atributosObjeto as $nombreAtributo => $valor) {
                    if ($fila[$nombreAtributo] != $valor) {
                        array_push($nombreColumnasCambiadas,$nombreAtributo);
                    }
                }
                
                foreach ($nombreColumnasCambiadas as $ola) {
                    
                }
                
            
                return $nombreColumnasCambiadas;
            
            

        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    public function obtenerTipoLongitud(){
        $consulta = $this->conexion->prepare(
                                                "SELECT DATA_TYPE, CHARACTER_MAXIMUM_LENGTH
                                                FROM information_schema.columns
                                                WHERE TABLE_NAME = {$this->tabla} AND TABLE_SCHEMA = {$this->conexion->__get('database')};");

        // Ejecutamos la consulta preparada
        $consulta->execute();

    }



}

?>