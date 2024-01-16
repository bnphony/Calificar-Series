<?php 
if (isset($_POST['email'])) {
    $url = "http://" . $_SERVER['HTTP_HOST'] . "/Trabajos_PHP/Calificar_Series";
    $email = $_POST['email'];
    $val = true;
    $token = bin2hex(openssl_random_pseudo_bytes(16, $val));

    $token_hash = hash("sha256", $token);

    // El toquen solo es valido por 30 minutos
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    require_once "../database.php";
    
    $sql = "UPDATE usuarios 
        SET reset_token_hash = ?, 
            reset_token_expires_at = ? 
        WHERE Usuario = ?";
    
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();
    $respuesta = array();
    if ($mysqli->affected_rows) {
        // header("Location: $url/funciones/token-reset.php?token=$token");
//         require_once "mailer.php";
//         $mail->setFrom("noreply@example.com");
//         $mail->addAddress($email);
//         $mail->Subject = "Password Reset";
// // <<END {contenido} END; -> El contenido debe ir pegado al inicio de linea
// $mail->Body = <<<END
// Click <a href="http://example.com/reset-password.php?token=$token">here</a> 
// to reset your password.
// END;
//         try {
//             $mail->send();
//         } catch (Exception $e) {
//             echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
//         }
        $respuesta = array("estado" => true, "mensaje" => "funciono", "url" => $url . "/funciones/token-reset.php?token=$token");
        echo json_encode($respuesta);
        die();
    }
    $respuesta = array("estado" => false, "mensaje" => "No");
    echo json_encode($respuesta);
}


?>