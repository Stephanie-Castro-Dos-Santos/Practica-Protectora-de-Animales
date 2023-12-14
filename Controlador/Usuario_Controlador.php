<?php
    require_once "Modelo/Usuario.php"; 

    class Usuario_Controlador{
        
        //CONSTRUCTOR
        public function __construct(){
            //Creamos variable USUARIO que serpo USUARIO
            $this->usuario = new Usuario();
        }

        //Función pública que nos permite mostrar los usuarios de la tabla USUARIO
        public function mostrarUsuarios(){
           
          $usuarios = $this->usuario->obtieneTodos(); 
    
            foreach ($usuarios as $usuario) {
            //$this->usuario se convierte en una propiedad de la clase y permite accede   

                echo "<tr>";

                foreach($usuario as $key => $value) {
                    echo "<td>{$value}</td>";
                }

                echo "</tr>";
            }
        }


          // Nuevo método para eliminar un usuario
    public function eliminarUsuario($id) {
        $this->usuario->borrar($id);
        echo "Usuario eliminado correctamente.";
    }
    }
?>