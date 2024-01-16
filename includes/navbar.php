<?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/Trabajos_PHP/Calificar_Series"; ?>
<style>
    .nav-principal {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 10px;
        background-color: steelblue;
        align-items: center;
    }

    .nav-principal > div a {
        color: #FFF;
        font-size: 20px;
    }

    .cont-1 {
        align-items: center;
    }

    .cont-1 img {
        width: 30px;
        height: 30px;
        aspect-ratio: 4/3;
        object-fit: scale-down;
    }

    .cont-1 > a:nth-child(1)  {
        color: #FFF;
        text-decoration: none;
    }
    
    

    .cont-2 a > i:hover  {
        color: red !important;
    }
    

</style>

<nav class="navbar navbar-expand navbar-light bg-light row">
    <ul class="nav navbar-nav px-4 nav-principal">
        <div class="cont-1 d-flex">
            <a class="nav-item me-3" href="<?= $url; ?>/inicio.php">
                <div class="d-flex align-items-center">
                    <img src="static/img/murasa.png" loading="lazy"></img>
                    <span>Sistema de Calificación de Series</span>
                </div>
            </a>
            <a class="nav-item nav-link active" href="<?= $url; ?>/inicio.php">Inicio</a>
        </div>
        <div class="cont-2">
            <a class="nav-item nav-link btn-cerrar-sesion" title="Cerrar Sesion" href="<?= $url; ?>/funciones/cerrar_sesion.php">
                <i class="fa-solid fa-power-off text-light fs-4"></i>
            </a>
        </div>
    </ul>
    <!-- <ul class="nav navbar-nav justify-content-end px-4">
        
    </ul> -->
    
</nav>