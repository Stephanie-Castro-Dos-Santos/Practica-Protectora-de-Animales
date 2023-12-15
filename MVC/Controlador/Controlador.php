<?php

//Llamadas a las clases del MODELO

class Controlador
{
    private $modelo;
    private $elemento;

    /* ---------------------------------------------------------------------- */

    // Constructor
    public function __construct($mod)
    {
        $this->modelo = "Modelo/" . $mod . ".php";

        require_once $this->modelo;

        $this->elemento = new $mod;
    }

    /* ---------------------------------------------------------------------- */
    // MÉTODOS MÁGICOS

    //__get()
    function __get($propiedad)
    {
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }

    //__set()
    function __set($propiedad, $valor)
    {
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad = $valor;
        }
    }

    /* ---------------------------------------------------------------------- */
    //MÉTODOS PÚBLICOS
    public function mostrarColumnas(){
        $columnas=$this->elemento->obtenerAtributos();

        foreach($columnas as $columna=>$valor){
            echo "<th>$columna</th>";
        }
    }



    public function mostrarDatos()
    {
        $elementos = $this->elemento->obtieneTodos();

        foreach ($elementos as $elemento) {
            echo "<tr>";

            foreach ($elemento as $key => $value) {
                echo "<td><input type='text' value='{$value}'></td>";
            }

            echo "<td>
                <button>Modificar</button>
                <button type='submit' name='eliminar_elemento'>Eliminar</button>
            </td>";

            echo "</tr>";
        }
    }

    public function mostrarCrear(){
        $elementos = $this->elemento->obtenerAtributos();

        echo "<tr>";

        foreach ($elementos as $elemento => $valor) {
            echo "<td>
                    <input type='text' placeholder='$elemento'>
                </td>";
        }

        echo "<td>
                <button>Crear</button>
            </td>";

        echo "</tr>";
    }

    //BORRADO DE REGISTROS
    /* He comentado de la linea 153 a la 155 en crud el metodo borrar porque al borrar 
    un registro me saltaba el mensaje de que no existía justo despues del borrado de forma automática.
    de esta forma ya no pasa eso, aunque hay que ver una forma para recargar la página y que se vea el 
    borrado automático sin pulsar f5 manualmente */
    public function eliminarElemento($id)
    {
        // Verificar si se ha enviado la solicitud de eliminación
        if (isset($_POST['eliminar_elemento'])) {
            // Obtener el ID del elemento a eliminar
            $id_elemento = $_POST['id_elemento'];

            // Llamar al método borrar del modelo
            $resultado = $this->elemento->borrar($id_elemento);

            if ($resultado) {
                echo "Elemento eliminado correctamente.";
            } 
        }
    }

    public function propiedades()
    {
        $atributos = get_class_vars(get_class($this->elemento));

        foreach ($atributos as $atributo) {
            echo "<label>{$atributo}:</label>";
            echo "<input type='text' name='{$atributo}'>";
        }
    }


    
    function devolverSelect($tabla){
        
        $crud = new CRUD($tabla);

        return $crud->obtieneTodos();
    }

    function llamarBorrar($objeto){
        if(isset($_POST['borrar'])){

            $crud = new CRUD($objeto::TABLA);
            
            $objeto->id=$_POST['id'];

            $crud->borrar($objeto->id);
            echo "Se ha eliminado con exito";
        }
    }

    function llamarActualizar($objeto){
        
        if(isset($_POST['actualizar'])){
            
            //Se le dan los atributos al objeto:

            foreach($objeto->obtenerAtributos() AS $atributo => $valor){
            
                $objeto->$atributo = $_POST[$atributo]; //Nombre COLUMNA
            }

            $crud = new CRUD($objeto::TABLA);

            $crud->actualizar($objeto);

            
        }

    }

}
?>