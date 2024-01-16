<?php 
// El nombre de la clase debe ser igual al nombre del arhivo
class conexion {
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct() {
        $listaDatos = $this->datosConexion();
        foreach ($listaDatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->conexion = new mysqli($this->server, $this->user, 
            $this->password, $this->database, $this->port);
        if ($this->conexion->connect_errno) {
            echo "Algo salio mal";
            die();
        }
    }

    private function datosConexion() {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }

    private function convertirUTF8($array) {
        array_walk_recursive($array, function(&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    // Listar los datos
    public function obtenerDatos($sqlstr) {
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key; // Similar a array.push();
        }
        return $this->convertirUTF8($resultArray);
    }

    // Devuelte el numero de filas afactadas
    public function nonQuery($sqlstr) {
        $results = $this->conexion->query($sqlstr);
        if ($this->conexion->affected_rows > 0) {
            return $this->conexion->affected_rows;
        } else {
            return 'no_cambios';
        }
        
    }

    public function nonQueryId($sqlstr) {
        $results = $this->conexion->query($sqlstr);
        $files = $this->conexion->affected_rows;
        if ($files >= 1) {
            return $this->conexion->insert_id;
        } else {
            return 0;
        }
    }

    protected function encriptar($string) {
        return md5($string);
    }
}

?>