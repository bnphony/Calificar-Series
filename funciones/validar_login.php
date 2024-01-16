<?php 
session_start();
// require_once 'clases/auth.class.php';
// $_auth = new auth;
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
} else {
    if ($_SESSION['usuario'] == "ok") {        
        $nombreUsuario = $_SESSION['nombreUsuario'];
        $idUsuario = $_SESSION['usuarioId'];
        // $resp = $_auth->comprobarToken($idUsuario); // Las lineas comentadas es para comprobar si todavida esta
            // activo el token, pero si se activa se DEMORA en cargar la pagina
        // if ($resp === 'Inactivo') {
        //     header("Location: funciones/cerrar_sesion.php");
        // }
    }
}
?>
