
<?php 

if (isset($_POST["token"])) {
    $token = $_POST["token"];

    $result = array();

    $token_hash = hash("sha256", $token);
    
    require_once "../database.php";
    
    $sql = "SELECT * FROM usuarios  
            WHERE reset_token_hash = ?";
    
    $stmt = $mysqli->prepare($sql);
    
    $stmt->bind_param("s", $token_hash);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $user = $result->fetch_assoc();
    
    if ($user === null) {
        die("token not found");
    } 
    
    // Comparar Fechas
    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        $result = array("estado" => false, "mensaje" => "Token has expired");
        echo json_encode($result);
        die();
    }
    
    // Comprobar el numero de caracteres permitidos
    if (strlen($_POST["password"]) < 8) {
        $result = array("estado" => false, "mensaje" => "El Password debe contener al menos 8 caracteres");
        echo json_encode($result);
        die();
    }
    
    // Comprobar si contiene al menos una letra
    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        $result = array("estado" => false, "mensaje" => "El Password debe contener al menos una letra");
        echo json_encode($result);
        die();
    }
    
    // Comprobar si contiene al menos un numero
    if (!preg_match("/[0-9]/", $_POST["password"])) {
        $result = array("estado" => false, "mensaje" => "El Password debe contener al menos un numero");
        echo json_encode($result);
        die();
    }
    
    // Comprobar si el password y la confirmacion son iguales
    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        $result = array("estado" => false, "mensaje" => "Los Passwords no coinciden");
        echo json_encode($result);
        die();
    }
    
    // SOLO FUNCIONA EN VERSIONES PHP 5.5 o superiores
    // $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); 
    
    $password_hash = md5($_POST["password"]);
    
    $sql = "UPDATE usuarios 
            SET password = ?, 
                reset_token_hash = NULL, 
                reset_token_expires_at = NULL 
            WHERE UsuarioId = ?";
    
    $stmt = $mysqli->prepare($sql);
    
    $stmt->bind_param("ss", $password_hash, $user["UsuarioId"]);
    
    $stmt->execute();
    
    $result = array("estado" => true, "mensaje" => "El Password se actualizo correctamente");
    echo json_encode($result);
}


?>