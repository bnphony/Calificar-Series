<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

// Cuando se hereda, se puede utilizar todos los metodos menos los PRIVATE
class auth extends conexion{
    private $tokens = array();

    public function login($json) {
        $_respuestas = new respuestas;
        $datos = $json;
        if (!isset($datos['usuario']) || !isset($datos['password'])) {
            // Error con los campos
            return $_respuestas->error_400();
        } else {
            // Todo esta bien
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);
            $datos = $this->obtenerDatosUsuario($usuario);
            if ($datos) {
                // Si existe el usuario
                // Verificar si el password es igual
                if ($password == $datos[0]['Password']) {
                    if ($datos[0]['Estado'] == "Activo") {
                        // Crear el token
                        $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                        if ($verificar) {
                            // Si se guardo
                            $result = $_respuestas->response;
                            $result["result"] = $usuario; 
                            $result["usuarioId"]  = $datos[0]['UsuarioId'];
                            return $result;
                        } else {
                            // No se guardo
                            return $_respuestas->error_500("Error interno, No hemos podido guardar");
                        }
                    } else {
                        // El usuario esta inactivo
                        return $_respuestas->error_200("El Usuario esta Inactivo");
                    }
                } else {
                    // El password no es igual
                    return $_respuestas->error_200("El password es invalido");
                }

            } else {
                // No existe el usuario
                return $_respuestas->error_200("El usuario $usuario no existe");
            }
        }
    }

    private function obtenerDatosUsuario($correo) {
        $query = "SELECT UsuarioId, Password, Estado FROM usuarios WHERE Usuario = '$correo'";
        // parent:: Utilizar las funciones del padre
        $datos = parent::obtenerDatos($query);
        if (isset($datos[0]["UsuarioId"])) {
            return $datos;
        } else {
            return 0;
        }
    }

    private function insertarToken($usuarioId) {
        $val = true; // La funcion de abajo solo acepta variables no se puede poner el valor directamente
        // bin2hex() -> Convertir de Binario a Hexadecimal
        // openssl_random_pseudo_bytes() -> genera un numero binario pseudo random
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $date = date("Y-m-d H:i"); // Debe ser el formato de la base de datos
        $estado = "Activo";
        $comprobar = $this->obtenerToken($usuarioId);
        if (count($comprobar) >= 1) {
            $query = "UPDATE usuarios_token SET Token = '$token', Estado = '$estado', Fecha = '$date'  
            WHERE TokenId = '" . $comprobar[0]['TokenId'] . "'";
        } else {
            $query = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha) VALUES 
                ('$usuarioId', '$token', '$estado', '$date')";      
            
        }
        $verifica = parent::nonQuery($query);
        if ($verifica) { 
            return $token;
        } else {
            return 0;
        }
       
    }

    public function obtenerToken($id) {
        $query = "SELECT TokenId FROM usuarios_token WHERE UsuarioId = '$id' LIMIT 1";
        return parent::obtenerDatos($query);
    }

    public function comprobarToken($id) {
        $query = "SELECT Estado FROM usuarios_token WHERE UsuarioId = '$id' LIMIT 1";
        $resp = parent::obtenerDatos($query);
        if ($resp[0]['Estado'] == 'Activo') {
            return 'Activo';
        } else {
            return 'Inactivo';
        }
    }

}
?>