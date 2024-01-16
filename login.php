<?php include_once("includes/header.php"); ?>
<?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/Trabajos_PHP/Calificar_Series"; ?>
<link rel="stylesheet" type="text/css" href="static/css/login.css"/>

<div class="container text-center">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <br/><br/>
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form id="dataLogin" action="." method="POST" enctype="multipart/form-data">
              <!-- Email input -->
              <div class="form-outline">
                <label class="form-label" for="id-email">Usuario</label>
                <input type="email" name="usuario" id="id-email" class="form-control" placeholder="Ingrese su Correo Electronico" 
                  value="usuario1@gmail.com" required/>
              </div>
              <!-- Password input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="id-password">Password</label>

                <div class="mb-3 input-group">
                  <input type="password" value="123456" name="password" id="id-password" class="form-control"  placeholder="Ingrese su Password" required/>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="fa-solid fa-eye text-dark"></i>
                  </button>
                </div>
              </div>
              <!-- 2 column grid layout for inline styling -->
              <div class="row mb-4 text-center">
                <div class="col">
                  <!-- Simple link -->
                  <a href="reset-password.php">Olvidaste tu Password?</a>
                </div>
              </div>
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">Iniciar Sesion</button>
              
            </form>
          </div>
            <div class="card-footer">
              <div class="text-center">
                  <p>No tienes una cuenta?<br/><a href="<?= $url; ?>/registrar.php">Registrate Ahora!</a></p>
              </div>
            </div>
        </div>
        <br/><br/>
    </div>
  </div>
</div>

<?php include_once("includes/scripts.php"); ?>

<script src="static/js/login.js" defer></script>
<?php include_once("includes/footer.php"); ?>