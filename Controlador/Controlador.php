<?php

    //Llamadas a las clases del MODELO

    class Controlador{
        private $modelo;
        private $elemento;

    /* ---------------------------------------------------------------------- */

        // Constructor
        public function __construct($mod){
            $this->modelo="Modelo/".$mod.".php";

            require_once $this->modelo;

            $this->elemento=new $mod;
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

        public function mostrarDatos(){
            $elementos = $this->elemento->obtieneTodos(); 
    
            foreach ($elementos as $elemento) {
            //$this->usuario se convierte en una propiedad de la clase y permite accede   

                echo "<tr>";

                foreach($elemento as $key => $value) {
                    echo "<td>{$value}</td>";
                }

                //$insertar=$controlador->elemento->borrar();

                echo "<td>
                            <button>Modificar</button>
                            <button>Eliminar</button>
                    </td>";

                echo "</tr>"; 

               /*  echo "<td>
                <form method='post'>
                    <input type='hidden' name='id_elemento' value='{$elemento->id}'>
                    <button type='submit' name='eliminar_elemento'>Eliminar</button>
                  </form>
                 </td>";

                echo "</tr>"; */

            }                
        
        }

        //IDEA PARA BORRAR
        public function eliminarElemento($id) {
            $this->elemento->borrar($id);
            echo "Elemento eliminado correctamente.";
        }

        // Manejar la acción de eliminar
        
        /* if (isset($_POST['eliminar_elemento'])) {
        $id_elemento = $_POST['id_elemento'];
        $controlador->eliminarElemento($id_elemento);
        } */


        public function propiedades(){
            $atributos = get_class_vars(get_class($this->elemento));

            foreach($atributos as $atributo){
                echo "<label>{$atributo}:</label>";
                echo "<input type='text' name='{$atributo}'>";
            }
        }


        
    }
?>