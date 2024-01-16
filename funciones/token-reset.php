<?php 

$token = $_GET["token"];

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

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}
?>

<?php include_once("../includes/header.php"); ?>

<div class="col-md-6 offset-md-3 py-3">
    <div class="card">
        <div class="card-header">
            <h2>Reset Password</h2>
        </div>
        <form id="dataReset" method="POST" action="." method="POST">
            <div class="card-body">
                <div style="display: none;" class="alert alert-danger show fade alerta" role="alert">
                        <i class="fa-solid fa-triangle-exclamation text-danger"></i> <span class="error-message"> El usuario no Existe! </span>
                        <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                
                    
                <div class="form-group row d-flex px-3">
                    <label for="password"> Nuevo Password </label>
                    <div class="mb-3 input-group">
                        <input type="password" id="password" name="password" autofocus="true" required>
                        <button class="btn btn-outline-secondary togglePassword" type="button">
                            <i class="fa-solid fa-eye text-dark"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group row d-flex px-3"> 
                    <label for="password_confirmation">Confirmacion Password</label>
                    <div class="mb-3 input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                        <button class="btn btn-outline-secondary togglePassword" type="button">
                                <i class="fa-solid fa-eye text-dark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-footer row">
                <button type="submit" class="btn btn-primary">Guardar Informacion</button>
            </div>
        </form>
    </div>
</div>



<?php include_once("../includes/scripts.php"); ?>


<script src="<?= $url ?>/static/js/process_password.js" defer></script>

<?php include_once("../includes/footer.php"); ?>