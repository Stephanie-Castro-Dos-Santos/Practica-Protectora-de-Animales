<?php

//Llamadas a las clases del MODELO

class Controlador
{
    // ATRIBUTOS
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

    /* -------------------------------------------MÉTODOS VISTAS------------------------------------------- */
    //FUNCIÓN para mostrar los nombres de las COLUMNAS de la TABLA
    public function mostrarColumnas(){
        //1. Obtenemos TODOS los DATOS de la TABLA
        $columnas=$this->elemento->obtenerAtributos();

        // 2. Creamos un bucle FOREACH para OBTENER las CELDAS
        foreach($columnas as $columna=>$nombre){
            // 3. Transformarmos el "NOMBRE" de la COLUMNA para que esté en MASYÚSCULAS
            $nombre=strtoupper($nombre);

            // 4. Si el nombre es "idAnimal" o "idUsuario" -> se coloca una barra baja.
            if($nombre=="IDANIMAL" || $nombre=="IDUSUARIO"){
                $nombre=$string = str_replace("ID", "ID_", $nombre);
            }

            // 5. Finalmente mostramos el NOMBRE de la COLUMNA
            echo "<th>$nombre</th>";
        }
    }


    //FUNCIÓN para mostrar los DATOS de la TABLA en forma de INPUTS
    public function mostrarDatos()
    {
        // 1. Obtenemos todos los datos de la TABLA
        $elementos = $this->elemento->obtieneTodos();

        // 2. Creamos variables que contendran las opciones de sexo y género
        $sexos=["Masculino","Femenino"];
        $generos=["Macho","Hembra"];
        $optionSexo;
        $optionGenero;

        // 3. Utilizamos un FOREACH para imprimir los INPUT y SELECT
        foreach ($elementos as $elemento) {

            // 3.1 Creamos esta variable para luego ser utilizada por los botones de MODIFICAR y ELIMINAR. Si se usan contendrán el ID del FILA
            $elementoID=$elemento['id'];

            // 3.2 Creamos una nueva FILA
            echo "<tr>";
        
            // 3.3 Mostramos los DATOS de cada fila
            foreach ($elemento as $key => $value) {

                // 3.3.1 Si las PROPIEDADES SON SEXO o GÉNERO se implementará un SELECT para evitar ERRORES por parte del USUARIO
                if($key=='sexo'){

                    // Si el valor del DATO coincide con el primer elemento del ARRAY sexos (Masculino) --> La opción del SELECT pasa a ser Femenino
                    $optionSexo = ($value == $sexos[0]) ? $sexos[1] : $sexos[0];

                    // Creamos el SELECT
                    // NOTAS    --> (1) se hace distinción del TIPO de SELECT con el NOMBRE del ATRIBUTO con el ID del ELEMENTO
                    //          --> (2) la primera opción que se mostrará en el SELECT será el DATO REAL del OBJETO
                    echo "<td>
                            <select name='sexo_{$elementoID}'>
                                <option value='{$value}'>{$value}</option>
                                <option value='{$optionSexo}'>{$optionSexo}</option>
                            </select>
                    </td>";
                }
                elseif($key=='genero'){

                    // Si el valor del DATO coincide con el primer elemento del ARRAY géneros (Macho) --> La opción del SELECT pasa a ser Hembra
                    $optionGenero = ($value == $generos[0]) ? $generos[1] : $generos[0];

                    // Creamos el SELECT
                    // NOTAS    --> (1) se hace distinción del TIPO de SELECT con el NOMBRE del ATRIBUTO con el ID del ELEMENTO
                    //          --> (2) la primera opción que se mostrará en el SELECT será el DATO REAL del OBJETO
                    echo "<td>
                            <select name='genero_{$elementoID}'>
                                <option value='{$value}'>{$value}</option>
                                <option value='{$optionGenero}'>{$optionGenero}</option>
                            </select>
                    </td>";
                }
                else{
                    //3.3.2 Si la PROPIEDAD es DISTINTA a SEXO y GÉNERO --> solo se mostrará su INPUT. Se hace distinción del MISMO con el NOMBRE y el ID
                    echo "<td><input type='text' name='{$key}_{$elementoID}' value='{$value}'></td>";
                }

            }

            // 3.4 Se generan los BOTONES de ELIMINAR y MODIFICAR --> se caracterizan por tener como VALOR el ID del OBJETO ELEGIDO
            echo "<td>
                <button type='submit' name='modificar_elemento' value='{$elementoID}'>Modificar</button>
                <button type='submit' name='eliminar_elemento' value='{$elementoID}'>Eliminar</button>
            </td>";

            // 3.5 Cerramos la FILA
            echo "</tr>";

        }
    }

    public function mostrarCrear(){
        // 1. Obtenemos TODOS los REGISTROS de la TABLA a través del OBJETO
        $elementos = $this->elemento->obtenerAtributos();

        // 2. Creamos la fila del REGISTRO
        echo "<tr>";


        // 3. Recorremos cada uno de los ATRIBUTOS para crear las celdas correspondientes
        foreach ($elementos as $elemento => $valor) {

            // 4. SI es SEXO / GENERO --> Creamos un formulario SELECT para evitar la mala introducción de DATOS
            if($valor=='sexo'){

                echo "<td>
                        <select name='sexo'>
                            <option value='Masculino'>Masculino</option>
                            <option value='Femenino'>Femenino</option>
                        </select>
                </td>";
            }
            elseif($valor=='genero'){

                echo "<td>
                        <select name='genero'>
                            <option value='Hembra'>Hembra</option>
                            <option value='Macho'>Macho</option>
                        </select>
                </td>";
            }
            else{
                // 5. Creamos el resto de INPUTS
                echo "<td>
                        <input type='text' name='{$valor}'placeholder='{$valor}'>
                    </td>";
            }


        }

        //6. BOTÓN CREAR

        echo "<td>
                <input type='submit' name='crear_elemento' value='Crear'>
            </td>";

        //7. Cerramos la FILA
        echo "</tr>";
    }

    /* -------------------------------------------MÉTODOS CRUD------------------------------------------- */

    /* -------------------------------------------DELETE------------------------------------------- */
    public function eliminarElemento()
    {
        if (isset($_POST['eliminar_elemento'])) {
            // 1. Obtenemos el DATO a través del BOTÓN ELIMINAR
            $id_elemento = $_POST['eliminar_elemento'];
    
            // 2. Llamar al método borrar del modelo
            $resultado = $this->elemento->borrar($id_elemento);
        }
    } 
    

    /* -------------------------------------------INSERT------------------------------------------- */
    public function crearElemento(){
        try{
            if(isset($_POST["crear_elemento"])){

                // 1. Obtener los atributos del elemento
                $atributos = $this->elemento->obtenerAtributos();
        
                // 2. Inicializar un array para almacenar los datos modificados
                $propiedades = [];
        
                // 3. Recorrer los atributos para INTRODUCIR los datos del POST en "propiedades"
                foreach ($atributos as $atributo) {
        
                    // 3.1 Verificar si el campo existe en $_POST
                    if (isset($_POST[$atributo])) {
                        // 3.1.1 Almacenar el valor en el array de datos modificados
                        $propiedades[$atributo] = $_POST[$atributo];
                    }
                }
    
    
                // 4. Obtenemos la longitud y el tipo de dato de la BBDD
                $arrayTipoLong=$this->elemento->obtenerTipoLongitud($this->elemento);
                
                // 5. Comprobamos la compatibilidad con la BBDD y si el ID no está duplicado
                if($this->comprobacionDatos($arrayTipoLong,$propiedades)==true && $this->comprobacionPK($propiedades["id"], $propiedades["id"],"crear")==true){

                    // 6. Insertamos los datos en el OBJETO
                    foreach($propiedades as $propiedad=>$valor){
                        $this->elemento->__set($propiedad,$valor);
                    }
                    
                    // 7. Si es la tabla ADOPCIÓN hay que verificar que los ID existen en sus TABLAS ORIGINALES
                    if($this->elemento::TABLA=="adopcion"){

                        // 7.1 Introducimos los IDs en el ARRAY "idFK"
                        $idFK["idUsuario"]=$propiedades["idUsuario"];
                        $idFK["idAnimal"]=$propiedades["idAnimal"];

                        // 7.2 Llamamos a la función para comprobar la EXISTENCIA de los IDs
                        $this->comprobacionFK($idFK);
                    }

                    // 8. Llamamos al método CREAR del CRUD a través del OBJETO
                   $this->elemento->crear($this->elemento);
                }

            }
        }
        // AQUÍ SE RECOGEN LAS EXCEPCIONES PERSONALIZADAS
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    
    /* -------------------------------------------UPDATE------------------------------------------- */
    // Método público para actualizar datos

    public function actualizarElemento()
    {
        try{

            if (isset($_POST['modificar_elemento'])) {
                // 1. Obtener el ID del elemento a modificar
                $idModificacion = $_POST["modificar_elemento"];
        
                // 2. Obtener los atributos del elemento
                $atributos = $this->elemento->obtenerAtributos();
        
                // 3. Inicializar un array para almacenar los datos modificados
                $datosModificados = [];
        
                // 4. Recorrer los atributos para obtener los datos modificados
                foreach ($atributos as $atributo) {
                    // 4.1 Construir el nombre del campo en el formulario (por ejemplo, 'nombre_4')
                    $nombreCampo = $atributo . '_' . $idModificacion;
        
                    // 4.2 Verificar si el campo existe en $_POST
                    if (isset($_POST[$nombreCampo])) {
                        // 4.2.1 Almacenar el valor en el array de datos modificados
                        $datosModificados[$atributo] = $_POST[$nombreCampo];
                    }
                }
        
                // 5. Obtenemos la longitud y el tipo de dato de la BBDD
                $arrayTipoLong=$this->elemento->obtenerTipoLongitud($this->elemento);
    
                // 6. Realizamos la COMPROBACIÓN del TIPO de DATO y su LONGITUD y la del ID
                if($this->comprobacionDatos($arrayTipoLong,$datosModificados)==true && $this->comprobacionPK($idModificacion, $datosModificados["id"],"actualizar")==true){
                    
                    // 6.1 Si es la tabla ADOPCIÓN hay que verificar que los ID existen en sus TABLAS ORIGINALES
                    if($this->elemento::TABLA=="adopcion"){

                        // 6.1.1 Introducimos en el ARRAY los valores de las FKs y PK
                        $idFK["idUsuario"]=$datosModificados["idUsuario"];
                        $idFK["idAnimal"]=$datosModificados["idAnimal"];

                        // 6.1.2 Llamamos a la función para comprobar la EXISTENCIA de los IDs
                        $this->comprobacionFK($idFK);
                    }

                    // 6.2 Si no se ha lanzado NINGUNA EXCEPCIÓN --> ACTUALIZAMOS EL DATO
                    $this->elemento->actualizar($idModificacion, $datosModificados);
                }

    
            }
        }
        // AQUÍ SE RECOGEN LAS EXCEPCIONES PERSONALIZADAS
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /* -------------------------------------------MÉTODOS AUXILIARES------------------------------------------- */
    public function comprobacionDatos($array,&$propiedades){

        //VARIABLES
        $errorMsg;

        // 1. CAMBIAMOS EL ARRAY ASOCIATIVO A UNO NUMÉRICO
        $array=array_map('array_values', $array); // Array con los TIPOS de DATOS y la LONGITUD del DATO
        $propiedadesNum=array_values($propiedades); // Array con las PROPIEDADES del OBJETO


        // 2. Como el array de los TIPOS y su LONGITUD posee la misma cantidad que el array de DATOS => recorreremos para verificar el tipo
        for($i=0;$i<count($array) && empty($errorMsg);$i++){

            // 3. Aplicamos otro bucle FOR para recorrer el array de TIPOS y LONGITUD
            for($j=0;$j<count($array[0]) && empty($errorMsg);$j++){

                // 3.1 Si el TIPO de DATO es INT
                if($array[$i][$j]=="int"){
                    // 3.1.1 Si el DATO es NUMÉRICO y NO está vacío
                    if(is_numeric($propiedadesNum[$i]) && !empty($propiedadesNum[$i])) {
                        // 3.1.2 Se cambia el TIPO de DATO en el ARRAY
                        settype($propiedadesNum[$i], $array[$i][$j]);
                    }
                    else{
                        // 3.1.3 De lo CONTRARIO se generará un mensaje de ERROR
                        $errorMsg="ERROR. El campo de debe ser de tipo NUMÉRICO";
                    }

                // 3.2 Si el TIPO de DATO es VARCHAR y SUPERA la LONGITUD permitida por la BBDD
                }elseif($array[$i][$j]=="varchar" && strlen($propiedadesNum[$i])>(int)$array[$i][1]){

                    // 3.2.1 Se generará un mensaje de ERROR
                    $errorMsg="ERROR. La longitud del dato introducido es mayor a la aceptada";
                }
                // 3.3 Si el TIPO de DATO es DATE y su CONVERSIÓN es FALSE
                elseif($array[$i][$j]=="date" && $this->fechaCorrecta($propiedadesNum[$i])==false){
                    // 3.3.1 Se generará un mensaje de ERROR
                    $errorMsg="ERROR. El fecha introducida es incorrecta";
                }

            }
        }

        // 4. Si la VARIABLE "errorMsg" NO está VACÍA
        if(!empty($errorMsg)){
            // 4.1 Lanzamos la EXCEPCIÓN con el MENSAJE personalizado
            throw new Exception($errorMsg);
        }
        // 5. Si no cumple con la CONCIÓN
        else{
            // 5.1 Obtenemos los ÍNDICES DEL ARRAY ORIGINAL de "propiedades" 
            $keys=array_keys($propiedades);

            // 5.2 Obtenemos los VALORES del ARRAY SECUNDARIO de "propiedadesNum"
            $values=array_values($propiedadesNum);

            // 5.3 Los COMBINAMOS para tener ACTUALIZADOS los DATOS
            $propiedades=array_combine(array_keys($propiedades),$propiedadesNum);

            // 5.4 Devuelve TRUE
            return true;
        }

    }

    public function fechaCorrecta($cadenaFecha) {
        // Intentar crear un objeto DateTime a partir de la cadena de fecha
        $fecha = DateTime::createFromFormat('Y-m-d', $cadenaFecha);
    
        // Verificar si se creó correctamente y si la fecha está completa
        if ($fecha !== false && $fecha->format('Y-m-d') === $cadenaFecha) {
            return true;
        } else {
            return false;
        }
    }

    // FUNCIÓN para comprobar la EXISTENCIA de la FK en sus tablas ORIGINALES
    public function comprobacionFK($idFK){
        // 1. Llamamos a las CLASES
        require_once "Modelo/Animal.php";
        require_once "Modelo/Usuario.php";

        // 2. Instanciamos los OBJETOS
        $idAnimal = new Animal();
        $idUsuario = new Usuario();

        // 3. Comprobamos si el ID que hemos recibido existe en la tabla correspondiente
        // 3.1 Si el idAnimal o idUsuario no se encuentran en sus respectivas tablas --> saltará una Excepción
        if(empty($idAnimal->obtieneDeID($idFK["idAnimal"])) || empty($idUsuario->obtieneDeID($idFK["idUsuario"]))){
            throw new Exception("ERROR. No se puede insertar o actualizar la tabla con un ID inexistente en la tabla ORIGINAL");
        }

    }

    // FUNCIÓN para comprobar la EXISTENCIA del ID en misma TABLA
    // NOTA --> Al ser UTILIZADA por CREAR y ACTUALIZAR, el comportamiento de la VERIFICACIÓN cambia

    public function comprobacionPK($idOriginal,$idNueva,$operacion){

        if($operacion=="actualizar"){
            // Si en la operación ACTUALIZAR el idOriginal y el idNuevo son distintos y en la TABLA a la que pertenecen DEVUELVE el MISMO ID --> se lanza una excepción
            if($idNueva!=$idOriginal && !empty($this->elemento->obtieneDeID($idNueva))){
                throw new Exception("ERROR. Duplicación del ID");
            }
        }
        elseif($operacion=="crear"){
            // Si en la operación CREAR se encuentra el MISMO ID --> se lanza una excepción
            if (!empty($this->elemento->obtieneDeID($idNueva))) {
                throw new Exception("ERROR. Duplicación del ID");
            }
        }

        // Si nada de esto OCURRE --> se devuelve TRUE
        return true;

    }


}


?>