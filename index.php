<?php 
    require_once("funciones/validar_login.php");
    include_once("includes/header.php"); 
    include_once("includes/navbar.php");
    include_once("includes/breadcrumb.php");
?>



<main>
    <div class="row">
        <div class="contenedor-categoria">
            <div class="info-categoria">
                <h2 id="titulo-categoria">Titulo Categoria</h2>
            </div>
            <div class="btn-config-categoria btn btn-secondary desactivar-div">
                <i class="fa-solid fa-gear"></i>
            </div>
        </div>
    </div>

    <h1>Valoración de Series</h1>
    <fieldset class="row">
        <legend>Registrar una Serie</legend>
        <form id="data" action="." method="POST" enctype="multipart/form-data">
            <div class="row">
                <label class="col-sm-2" for="id_nombre">
                    Nombre de la Serie: </label>
                <input class="col-sm-10" type="text" name="nombre" id="id_nombre"
                    value="anime nuevo" placeholder="Ingrese el Nombre del Anime" required>
            </div>
            <div class="row">
                <label class="col-sm-2" for="id_logo">
                    Logo de la Serie: </label>
                <input class="col-sm-10" type="file" name="logo" id="id_logo" accept="image/*" required>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2" for="id_num_caps">
                    Numero de Capitulos: </label>
                <input class="col-sm-10" type="number" value="0" min="0" max="25" name="num_caps" id="id_num_caps" placeholder="0">
            </div>
            <button class="btn btn-block btnSubmitSerie" type="submit">Registrar</button>
        </form>
    </fieldset>
    <div class="gestion-data">
        <label for="id-subir-data" title="Subir Informacion">
            <div class="btn custom-file-upload"><i class="fa-solid fa-upload"></i></div>
        </label>
        <input type="file" id="id-subir-data" accept=".json" class="btn btn-flat btnSubirData">
        <button type="button" class="btn btn-flat btnDescargarData" title="Descargar la informacion">
            <i class="fa-solid fa-file-arrow-down"></i>
        </button>
    </div>
    <div class="resultados-totales row p-3">
        <button type="button" class="btn btn-flat btn-success btnVerResultados">Ver Resultados</button>
        <p class="justify-contente-center labelNumAnimes">Animes Calificados: </p>
    </div>
    <!-- Aqui van todos los Graficos -->
    <div class="contenedor-calificaciones">
        
    </div>
    <!-- Un solo elemento para todos -->
    <div class="elementos-compartidos">
        <div class="tooltip1" width="200px" height="200px">
            <h3 class="titulo">Titulo el Capitulo</h3>
            <img class="img-cap" src="img/img1.png" width="100px" height="100px" loading="lazy">
            <p class="descripcion">Descripcion del capitulo</p>
        </div>
        <div class="c_instrucciones">
            <h3>Instrucciones:</h3>
            <p>- Doble Click en el Capitulo para Editar la Informacion</p>
            <p>- Click Derecho para Eliminar un Capitulo</p>
        </div>
        
    </div>
    
</main>
<?php include_once("includes/modals.php");?>

<?php include_once("includes/scripts.php"); ?>

<!-- JAVASCRIPT SOLO PARA ESTE ARCHIVO -->
<!-- D3 -->
<script src="https://d3js.org/d3.v6.js" defer></script>
<!-- MyRangoColor2 -->
<!-- <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script> -->
<script src="static/js/index.js" defer></script>

<?php include_once("includes/footer.php"); ?>


