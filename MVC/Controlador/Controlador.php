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

        foreach($columnas as $columna=>$nombre){
            $nombre=strtoupper($nombre);
            echo "<th>$nombre</th>";
        }
    }


    public function mostrarDatos()
    {
        $elementos = $this->elemento->obtieneTodos();

        foreach ($elementos as $elemento) {
            echo "<tr>";

            foreach ($elemento as $key => $value) {
                echo "<td><input type='text' name='{$key}' value='{$value}'></td>";
            }

            echo "<td>
                <input type='submit' name='modificar_elemento' value='Modificar'>
                <input type='submit' name='eliminar_elemento' value='Eliminar'>
            </td>";

            echo "</tr>";

            /* echo "<td>
            <button>Modificar</button>
            <form method='POST' action='' onsubmit='recargarPagina()'>";
        echo "<input type='submit' name='eliminar_elemento' value='Eliminar'>";
        echo "<input type='hidden' name='id_elemento' value='{$elemento["id"]}'>";
        echo "</form>
        </td>";

        echo "</tr>"; */
        }
    }

    public function mostrarCrear(){
        $elementos = $this->elemento->obtenerAtributos();

        echo "<tr>";

        foreach ($elementos as $elemento => $valor) {
            echo "<td>
                    <input type='text' name='{$valor}'placeholder='{$valor}'>
                </td>";
        }

        echo "<td>
                <input type='submit' name='crear_elemento' value='Crear'>
            </td>";

        echo "</tr>";
    }

        //BORRADO DE REGISTROS
    public function eliminarElemento()
    {
        // Verificar si se ha enviado la solicitud de eliminación
        if (isset($_POST['eliminar_elemento'])) {
            // Obtener el ID del elemento a eliminar
            $id_elemento = $_POST['id_elemento'];

            // Llamar al método borrar del modelo
            $resultado = $this->elemento->borrar($id_elemento);
        }
    }


    public function crearElemento(){
        if(isset($_POST["crear_elemento"])){

            print_r($_POST);
            var_dump($_POST);
            $propiedades=$_POST;
            array_shift($propiedades);

            foreach($propiedades as $propiedad=>$valor){
                $this->elemento->__set($propiedad,$valor);
            }
    
            $this->elemento->crear($this->elemento);

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

            foreach ($_POST as $key => $value) {
                $_POST[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
            }
            
            // Limpiar las variables $_GET
            foreach ($_GET as $key => $value) {
                $_GET[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
            }
            
            // Limpiar las variables $_REQUEST
            foreach ($_REQUEST as $key => $value) {
                $_REQUEST[$key] = filter_input(INPUT_REQUEST, $key, FILTER_SANITIZE_STRING);
            }

            
        }

    }

}
?>