<?php 
require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class series extends conexion {
    private $table = "serie";
    private $serieId = "";
    private $nombre = "";
    private $logo = "";
    private $fkCategoria = 0;

    // ATRIBUTOS EPISODIO
    private $value = 0;
    private $titulo = "Titulo Capitulo";
    private $descripcion = "Desc Capitulo";
    private $imagenEpisodio = "";
    private $numCaps = 0;

    public function listaSeries($pagina = 1, $idCategoria) {
        $inicio = 0;
        $cantidad = 100;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM " . $this->table . " WHERE fk_categoria = '$idCategoria' 
            LIMIT $inicio, $cantidad ";
        $datos = parent::obtenerDatos($query);
        return $datos; 
    } 

    public function listaEpisodios($serieId = 0) {
        $query = "SELECT * FROM episodio WHERE fk_serie = '$serieId'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function addSerie($json) {
        $_respuestas = new respuestas;
        // $datos = json_decode($json, true);
        if (!isset($json['nombre']) || !isset($json['id_categoria'])) {
            return $_respuestas->error_400();
        } else {
            $this->nombre = $json['nombre'];
            if (isset($json['num_caps'])) {
                $this->numCaps = intval($json['num_caps']);
            }
            $fecha = new DateTime();
            $this->logo = ($json['logo']['name'] != "") ? $fecha->getTimestamp() . "_" . $json["logo"]["name"] : "imagen.png";
            $tmpImagen = $json["logo"]["tmp_name"];

            if ($tmpImagen != "") {
                move_uploaded_file($tmpImagen, "../media/animes/" . $this->logo);
            }
            
            $this->fkCategoria = intval($json['id_categoria']);
            $resp = $this->insertarSerie();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "serieId" => $resp
                );
                for ($i = 0; $i < $this->numCaps;$i++) {
                    $this->addEpisodio($resp);
                }
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
            
        }
    }

    private function insertarSerie() {
        $query = "INSERT INTO " . $this->table . " (nombre, logo, fk_categoria) VALUES 
            ('" . $this->nombre . "','" . $this->logo . "', " . $this->fkCategoria . ")";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    public function addEpisodio($fk_serie) {
        $_respuestas = new respuestas;
        
        $query = "INSERT INTO episodio (titulo, descripcion, imagen, value, fk_serie) 
            VALUES 
            ('" . $this->titulo . "','" . $this->descripcion . "',
            'imagen.png','" . $this->value . "', '$fk_serie')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta['result'] = array(
                    "episodioId" => $resp
            );
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    public function actualizarValorEpisodio($idEpisodio, $newValue) {
        $_respuestas = new respuestas;
        $query = "UPDATE episodio SET value = '$newValue' 
            WHERE id = '$idEpisodio'";
        
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            $respuesta = $_respuestas->response;
            $respuesta['result'] = array(
                "episodioId" => $idEpisodio
            );
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    public function actualizarInfoEpisodio($json) {
        $_respuestas = new respuestas;
        if (!isset($json['id_capitulo'])) {
            return $_respuestas->error_400();
        } else {

            $this->titulo = $json['titulo'];
            $this->descripcion = $json['descripcion'];
            $query = "UPDATE episodio SET titulo = '" . $this->titulo . "', descripcion = '" . $this->descripcion . "' WHERE id = '" . $json['id_capitulo'] . "'"; 
            $resp = parent::nonQuery($query);
            
            $this->imagenEpisodio = $json['imagen']['name'];

            // Manejar Imagen
            if ($this->imagenEpisodio != "") {
                $fecha = new DateTime();
                $nombreArchivo = ($this->imagenEpisodio != "") ? $fecha->getTimestamp() . "_" . $json["imagen"]["name"] : "imagen.png";
                $tmpImagen = $json["imagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../media/episodios/" . $nombreArchivo);

                $imagen = $this->obtenerEpisodio($json['id_capitulo']);
                if (isset($imagen[0]["imagen"]) && ($imagen[0]["imagen"] != "imagen.png")) {
                    if (file_exists("../media/episodios/" . $imagen[0]["imagen"])) {
                        unlink("../media/episodios/" . $imagen[0]["imagen"]);
                    }
                }
                $query = "UPDATE episodio SET imagen = '" . $nombreArchivo . "' WHERE id = '" . $json['id_capitulo'] . "'"; 
                $resp = parent::nonQuery($query);
            }

           

            if ($resp >= 1 || $resp == 'no_cambios') {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "episodioId" => $json['id_capitulo']
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
           
           
        }   
    }

    public function actualizarInfoAnime($json) {
        $_respuestas = new respuestas;
        if (!isset($json['id-anime'])) {
            return $_respuestas->error_400();
        } else {
            $this->serieId = $json['id-anime'];
            $this->nombre = $json['config-anime'];
            
            $query = "UPDATE serie SET nombre = '" . $this->nombre . "' WHERE id = '" . $this->serieId . "'"; 
            $resp = parent::nonQuery($query);

            $this->logo = $json['config-logo']['name'];
            // Manejar Imagen
            if ($this->logo != "") {
                $fecha = new DateTime();
                $nombreArchivo = ($this->logo != "") ? $fecha->getTimestamp() . "_" . $json["config-logo"]["name"] : "imagen.png";
                $tmpImagen = $json["config-logo"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../media/animes/" . $nombreArchivo);

                $logo = $this->obtenerSerie($this->serieId);
                if (isset($logo[0]["logo"]) && ($logo[0]["logo"] != "imagen.png")) {
                    if (file_exists("../media/animes/" . $logo[0]["logo"])) {
                        unlink("../media/animes/" . $logo[0]["logo"]);
                    }
                }
                $query = "UPDATE serie SET logo = '" . $nombreArchivo . "' WHERE id = '" . $this->serieId . "'"; 
                $resp = parent::nonQuery($query);
            }

            if ($resp >= 1 || $resp == 'no_cambios') {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "serieId" => $this->serieId
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }   
    }

    public function eliminarEpisodio($idEpisodio) {
        $_respuestas = new respuestas;

        $imagen = $this->obtenerEpisodio($idEpisodio);
        if (isset($imagen[0]["imagen"]) && ($imagen[0]["imagen"] != "imagen.png")) {
            if (file_exists("../media/episodios/" . $imagen[0]["imagen"])) {
                unlink("../media/episodios/" . $imagen[0]["imagen"]);
            }
        }
        $query = "DELETE FROM episodio WHERE id = '$idEpisodio'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            $respuesta = $_respuestas->response;
            $respuesta['result'] = array(
                "episodioEliminado" => $idEpisodio
            );
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    public function eliminarSerie($idSerie) {
        $_respuestas = new respuestas;

        $logo = $this->obtenerSerie($idSerie);
        if (isset($logo[0]["logo"]) && ($logo[0]["logo"] != "imagen.png")) {
            if (file_exists("../media/animes/" . $logo[0]["logo"])) {
                unlink("../media/animes/" . $logo[0]["logo"]);
            }
        }

        $query = "DELETE FROM serie WHERE id = '$idSerie'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            $respuesta = $_respuestas->response;
            $respuesta['result'] = array(
                "serieEliminada" => $idSerie
            );
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }

    public function obtenerEpisodio($id) {
        $query = "SELECT imagen FROM episodio WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }

    public function obtenerSerie($id) {
        $query = "SELECT logo FROM serie WHERE id = '$id'";
        return parent::obtenerDatos($query);
    }



    // Manejo de Scripts
    private $pruebaQueries = array();
    public function subirDataJsonFile($json, $idCategoria) {
        if ($idCategoria) {
            $this->fkCategoria = $idCategoria;
            $queries = array();
            $index = 0;
            $index2 = 0;
            foreach ($json as $serie) {
                $queries[$index]['INFO'] = $serie['INFO'];
                $queries[$index]['NODOS'] = array();   
                $index2 = 0;         
                foreach ($serie['NODOS'] as $episodio) {
                    $queries[$index]['NODOS'][$index2]['titulo'] = $episodio['titulo'];
                    $queries[$index]['NODOS'][$index2]['imagen'] = $episodio['imagen'];
                    $queries[$index]['NODOS'][$index2]['descripcion'] = $episodio['descripcion'];
                    $queries[$index]['NODOS'][$index2]['value'] = $episodio['value'];
                    $index2++;
                }
                $this->addScriptSerie($queries[$index]);
                $index++;
            }
        }   
        return count($json);
    }

    public function addScriptSerie($json) {
        $_respuestas = new respuestas;
        if (!isset($json['INFO']['nombre'])) {
            return $_respuestas->error_400();
        } else {
            $this->nombre = $json['INFO']['nombre'];
            $this->logo = "imagen.png";
            if ($json['INFO']['logo'] != "") {
                $this->logo = $json['INFO']['logo'];
            }
            $this->table = "serie";
            $respIdSerie = $this->insertarSerie();
        
            if ($respIdSerie) {
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "serieId" => $respIdSerie
                );
                foreach ($json['NODOS'] as $episodio) {
                    $this->addScriptEpisodio($respIdSerie, $episodio);
                }
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }  
    }

    public function addScriptEpisodio($idSerie, $episodio) {
        $_respuestas = new respuestas;
        
        $query = "INSERT INTO episodio (titulo, descripcion, imagen, value, fk_serie) 
            VALUES 
            ('" . $episodio['titulo'] . "','" . $episodio['descripcion'] . "',
            '" . $episodio['imagen'] . "','" . $episodio['value'] . "', '$idSerie')";
        $resp = parent::nonQueryId($query);
        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta['result'] = array(
                    "episodioId" => $resp
            );
            return $respuesta;
        } else {
            return $_respuestas->error_500();
        }
    }


}

?>