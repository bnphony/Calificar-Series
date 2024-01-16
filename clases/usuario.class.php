<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class usuario extends conexion {
    public function registrarUsuario($datos) {
        $_respuestas = new respuestas;
        if (!isset($datos['usuario']) || !isset($datos['password'])) {
            return $_respuestas->error_400();
        } else {
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);
            $estado = 'Activo';

            $query = "INSERT INTO usuarios (Usuario, Password, Estado) 
                VALUES 
                ('$usuario', '$password', '$estado')";
            $resp = parent::nonQueryId($query);
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = "Usuario: " . $resp;
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }

        }
    }
}


?>