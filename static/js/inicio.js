const categoriasDiv = $('.contenedor-categorias');

function buscarCategorias() {
    $.ajax({
        url: 'funciones/categoria-list.php',
        type: 'GET',
        data: {
            'pagina': 1,
        },
        success: function(response) {
            console.log("REPEUST: ", response);
            if (response.length > 0) {
                graficarCategorias(response);
            } else {
                let label = $('<label>').text('No se encontraron registros!');
                categoriasDiv.append(label);
            }
        },
        error: function(xhr, status, error) {
            console.error("Resquest failed with status: " + status);
        }
    });
}

function consultarSeries(idCategoria) {
    $.ajax({
        url: 'funciones/inicio-add.php',
        type: 'POST',
        data: {
            'action': 'buscar_categoria',
            'id_categoria': idCategoria,
        },
        success: function(response) {
            location.href = 'index.php';
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    })
}

function graficarCategorias(data) {
    $('.contenedor-categorias').empty();
    data.forEach(function(item, index) {
        let contenedorDiv = $('<div>').addClass('contenedor_interno');
        contenedorDiv.attr('data-id', item['categoria_id']);
        let cImagen = $('<img>').addClass('imagen_categoria');
        cImagen.attr('src', () => {
            if (item['serie_imagen'] !== null) {
            return `media/animes/${item['serie_imagen']}`;
            } else {
            return 'media/animes/imagen.png';
            }
        });
        let cLabel = $('<label>').text(item['categoria_nombre']);
        cLabel.addClass('label_categoria');
        contenedorDiv.append(cImagen);
        contenedorDiv.append(cLabel);
        categoriasDiv.append(contenedorDiv);
    });
}

$(function() {
    buscarCategorias();

    $(document).on('click', '.contenedor_interno', function() {
        consultarSeries($(this).data('id'));
    });

    $('.btnAbrirModal').on('click', function() {
        $('#myModalCategoria').modal('show');
    }); 

    $('#myModalCategoria').on('hidden.bs.modal', function() {
        $('#dataCategoria')[0].reset();
    });

    $('#dataCategoria').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);
        data.append('action', 'registrar_categoria');
        registrarCategoria(data);
        $('#myModalCategoria').modal('hide');
    });
});


function registrarCategoria(datos) {
    $.ajax({
        url: 'funciones/categoria-list.php',
        type: 'POST',
        data: datos, // Ensure 'datos' is a FormData object
        processData: false,
        contentType: false, // Ensure jQuery does not set content type
        success: function(response) {
            buscarCategorias();
        }, 
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}