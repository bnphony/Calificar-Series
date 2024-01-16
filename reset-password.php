<?php include_once("includes/header.php"); ?>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-6 offset-md-3 form">
                <div class="card">
                    <form id="dataResetEmail" action="." method="POST" autocomplete="">
                        <div class="card-header">
                            <h2 class="text-center">Recuperar Password</h2>
                        </div>
                        <div class="card-body">
                            <p class="text-center">Ingrese su Usuario</p>
                           
                            <div style="display: none;" class="alert alert-danger fade show alerta" role="alert">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i> El usuario no Existe!
                                <button type="button" class="btn-close" aria-label="Close"></button>
                            </div>
                    
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Ingresa tu Usuario/Email" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input class="btn form-control btn-primary" type="submit" name="check-email" value="Continue">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php include_once("includes/scripts.php"); ?>

<script src="<?= $url ?>/static/js/reset_password.js" defer></script>

<?php include_once("includes/footer.php"); ?>

