<?php require_once("funciones/validar_login.php"); ?>

<?php include_once("includes/header.php"); ?>
<link rel="stylesheet" type="text/css" href="static/css/inicio.css"/>
<?php include_once("includes/navbar.php"); ?>

<h3>Bienvenido <?= $nombreUsuario ?></h3>
<div class="container">
    <div class="row">
        <h3 class="col-sm-10">Categorias</h3>
        <button type="button" class="btn btnAbrirModal col-sm-2">Agregar Categorias</button>
    </div>
    <div class="row">
        <div class="contenedor-categorias my-3">
            
        </div>
    </div>
</div>


<!-- MODAL CREAR CATEGORIA -->
<div class="modal fade" id="myModalCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Registrar Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="dataCategoria" action="." method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="id-nombre-categoria" class="col-sm-2 col-form-label">Nombre Categoria</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombre_categoria" class="form-control" id="id-nombre-categoria" 
                            placeholder="Ingrese el nombre de la Categoria" required>
                    </div>
                </div>                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary btnAddCategoria">Registrar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include_once ("includes/scripts.php"); ?>
<script src="static/js/inicio.js" defer></script>
<?php include_once("includes/footer.php"); ?>