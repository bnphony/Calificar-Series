<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'buscar_categoria') {
            $_SESSION['id_categoria'] = $_POST['id_categoria'];
        }  
    }
}
    

?>