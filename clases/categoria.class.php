<?php
session_start();
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class categorias extends conexion {
    private $table = "categoria";
    private $categoriaId = 0;
    private $nombre = "";
    private $usuarioId = 0;

    public function listaCategorias($pagina = 1) {
        
        $_respuestas = new respuestas;
        if (!isset($_SESSION['usuarioId'])) {
            return $_respuestas->error_400();
        } else {
            $inicio = 0;
            $cantidad = 20;
            if ($pagina > 1) {
                $inicio = ($cantidad * ($pagina - 1)) + 1;
                $cantidad = $cantidad * $pagina;
            }

            $idUsuario = $_SESSION['usuarioId'];
            // $query = "SELECT * FROM " . $this->table . " WHERE fk_usuario = " . $this->usuarioId . " 
            //  LIMIT $inicio, $cantidad";

            $query = "SELECT 
                    c.id AS categoria_id,
                    c.nombre AS categoria_nombre,
                    s.logo AS serie_imagen
                FROM 
                    categoria c
                LEFT JOIN 
                    serie s ON c.id = s.fk_categoria 
                WHERE fk_usuario = '$idUsuario' 
                GROUP BY categoria_id
                ORDER BY c.id 
                LIMIT $inicio, $cantidad;
            ";

            $datos = parent::obtenerDatos($query);
            return $datos;
        }
        

    }

    public function addCategoria($nombreCategoria) {
        $_respuestas = new respuestas;
        if (isset($_SESSION['usuarioId'])) {
            $idUsuario = $_SESSION['usuarioId'];
            $query = "INSERT INTO categoria (nombre, fk_usuario) 
                VALUES 
                ('$nombreCategoria', '$idUsuario')";
            $resp = parent::nonQueryId($query);
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = $resp;
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    public function buscarCategoria() {
        $this->categoriaId = $_SESSION['id_categoria'];
        $query = "SELECT id, nombre FROM categoria 
                WHERE id = " . $this->categoriaId;
        return parent::obtenerDatos($query);
    }

    public function actualizarCategoria($json) {
        if (!isset($json['id_categoria']) || !isset($json['nombre_categoria'])) {
            return $_respuestas->error_400();
        } else {
            $_respuestas = new respuestas;
            $id = $json['id_categoria'];
            $nombre = $json['nombre_categoria'];
            $query = "UPDATE categoria SET 
                    nombre = '$nombre' 
                    WHERE id = '$id'";
            $resp = parent::nonQuery($query);
            if ($resp >= 1) {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "id" => $id,
                    "nombre" => $nombre
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }   
    }

    public function eliminarCategoria($idCategoria) {
        if ($idCategoria) {
            if ($idCategoria == $_SESSION['id_categoria']) {
                $_respuestas = new respuestas;
                $query = "DELETE FROM categoria WHERE id = '$idCategoria'";
                $resp = parent::nonQuery($query);
                if ($resp >= 1) {
                    $respuesta = $_respuestas->response;
                    $respuesta['result'] = 'Se elimino la categoria!';
                    return $respuesta;
                } else {
                    return $_respuestas->error_500();
                }
            } else {
                return "La categoria de la sesion y la enviada no coinciden!";
            }
        }
    }

}


?>