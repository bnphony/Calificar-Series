<?php include_once("includes/header.php"); ?>
<?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/Trabajos_PHP/Calificar_Series"; ?>

<div class="container text-center">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <br/><br/>
        <div class="card">
          <div class="card-header">
            Crear Cuenta
          </div>
          <div class="card-body">
            <form id="dataRegistro" action="." method="POST" enctype="multipart/form-data" autocomplete="off">
              <!-- Email input -->
              <div class="form-group">
                <label class="form-label" for="email-usuario">Usuario / Email</label>
                <input type="email" name="usuario" id="email-usuario" class="form-control" placeholder="Ingrese su Email" 
                  value="usuario1@gmail.com" required/>
              </div>
              <!-- Password input -->
              <div class="form-group mb-4">
                <label class="form-label" for="password-usuario">Password</label>
                <input type="password" value="123456" name="password" id="password-usuario" 
                  class="form-control"  placeholder="Ingrese su Password" required/>
              </div>
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">Registrarse</button>
              
            </form>
          </div>
            <div class="card-footer">
              <div class="text-center">
                  <p>Ya tienes una Cuenta?<br/><a href="<?= $url; ?>/login.php">Inicia Sesion</a></p>
              </div>
            </div>
        </div>
        <br/><br/>
    </div>
  </div>
</div>

<?php include_once("includes/scripts.php"); ?>

<script src="static/js/registrar.js" defer></script>
<?php include_once("includes/footer.php"); ?>