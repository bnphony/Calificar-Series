
// let DATOSGENERALES = JSON.parse(localStorage.getItem('calificaciones')) || [];

let DATOSGENERALES = [];
let idCategoria = 0;

// Definicion de Constantes
const contCalificaciones = d3.select('.contenedor-calificaciones');

// Etiqueta hover de cada Episodio
const tooltip = d3.select('.tooltip1');
const titulo = d3.select('.titulo');
const descripcion = d3.select('.descripcion');
const imagen = d3.select('.img-cap');

// Modal Actualizar Episodio
const inputImagen = d3.select('#id-imagen-cap');
const showImagen = d3.select('#show-imagen');
const tituloCap = d3.select('#titulo-cap');
const descripcionCap = d3.select('#descripcion-cap'); 
const instrucciones = d3.select('.c_instrucciones');

// Modal Actualizar Serie
const configAnime = d3.select('#id-config-anime');
const configLogo = d3.select('#id-config-logo');
const configShowImage = d3.select('#config-show-image');


function crearDatos2(data) {
    let auxData = {"INFO": {nombre: 'Sin Nombre', logo: 'Sin Imagen'}, "NODOS": [], "LINKS": []};
    auxData["INFO"].nombre = data.get('nombre');
    auxData["INFO"].logo = data.get('logo');
    // CREAR LOS NODOS
    for (let i = 0, size = data.get('num_caps'); i < size; i++) {
        auxData["NODOS"].push({ id: `cap${i+1}`, value: 0, titulo: 'Titulo', imagen: 'img/img2.png', descripcion: 'Descripcion' });
    }    
    // CREAR LOS LINKS
    for (let i = 0, size = auxData['NODOS'].length; i < size - 1; i++) {
        auxData['LINKS'].push({ source: auxData['NODOS'][i], target: auxData['NODOS'][i+1]});
    }
    DATOSGENERALES.push(auxData);
    localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
    $('.labelNumAnimes').text(`Animes Calificados: ${DATOSGENERALES.length}`);
    return auxData;
}

function crearDatos(datos) {
    $.ajax({
        url: 'funciones/serie-add.php',
        type: 'POST',
        data: datos, // Ensure 'datos' is a FormData object
        processData: false,
        contentType: false, // Ensure jQuery does not set content type
        success: function(response) {
            if (response === 'Error_Max') {
                alert('El logo sobrepasa los 10 MB');
            } else {
                console.log("CREAR ANIME: ", response);
                buscarSeries();
                mainGrafico();
                $('#data')[0].reset();
            }
        }, 
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}


function mainGrafico() {
    contCalificaciones.selectAll('*').remove();
    for (let i = 0, len = DATOSGENERALES.length; i < len; i++) {
        let auxData = {"LINKS": []};
        for (let j = 0, size = DATOSGENERALES[i]['NODOS'].length; j < size - 1; j++) {
            auxData['LINKS'].push({ source: DATOSGENERALES[i]['NODOS'][j], target: DATOSGENERALES[i]['NODOS'][j+1]});
        }
        DATOSGENERALES[i]['LINKS'] = auxData['LINKS'];
        generarGrafico(DATOSGENERALES[i], i);   
    }
}

function generarGrafico(datos, index) {
    const MARGINS = {
        top: 100, bottom: 60, left: 50, right: 10
    };

    // CONTENEDOR GRAFICO
    
    
    let WIDTH1 = window.innerWidth * 0.8;
    let HEIGHT = 400;
    // console.log(`HEGIHT: ${HEIGHT} WIDTH: ${WIDTH1}`);
    const contGrafico = d3.select('.contenedor-calificaciones')
        .append('div')
        .attr('class', 'contenedor-grafico')
        .attr('width', WIDTH1);
        
    let WIDTH = contGrafico.attr('width') * 0.985;
    // console.log(`W1: ${WIDTH1} WIDTH: ${WIDTH}`);
    const title = datos['INFO'].nombre;

    let data = datos['NODOS'];
    let info = datos['INFO'];
    const links = datos['LINKS'];
 
    // const xScale = d3.scaleBand().rangeRound([MARGINS.left, WIDTH - MARGINS.right]).padding(0.1);
    const xScale = d3.scalePoint().range([MARGINS.left, WIDTH - MARGINS.right]).padding(0.2)
    const yScale = d3.scaleLinear().range([HEIGHT - MARGINS.bottom, MARGINS.top]);
    
    xScale.domain(data.map((d) => d.id) );
    yScale.domain([0, 10]);
    
    const svg = contGrafico
        .append('svg')
        .attr('width', WIDTH)
        .attr('height', HEIGHT);

    svg.append('rect')
        .attr('width', WIDTH)
        .attr('height', HEIGHT)
        .attr('x', 0)
        .attr('y', 0)
        .attr('fill', '#80BCBD');

    // BOTON AGREGAR MAS CAPITULOS
    let matchUltimoNumero = /[\d]+$/;   
    const addCapG = svg.append('g')
        .attr('class', 'g-addCap')
        .attr('transform', `translate(${WIDTH-140}, ${20})`)
        .on('click', () =>  {
            
            agregarEpisodio(DATOSGENERALES[index]['INFO'].id);
            data = DATOSGENERALES[index]['NODOS'];
            // xScale.domain(data.map((d) => d.id));
            // xAxisG.call(d3.axisBottom(xScale));
            // renderChart();
        });
    addCapG.append('rect')
        .attr('width', 90)
        .attr('height', 30)
        .attr('fill', 'red');
    addCapG.append('text')
        .text('+ Capitulos')
        .attr('dy', 20)
        .attr('dx', 5);
    
    
    

    const chart = svg.append('g');
    // BOTON DE AYUDA
    chart.append('text')
        .attr('class', 'ayuda')
        .attr('x', 30)
        .attr('y', 40)
        .text('?')
        .on('mouseenter', (event, d) => {
            const [x, y] = d3.pointer(event, this);  
            instrucciones
                .style('top', `${y}px`)
                .style('left', `${x}px`);   
            $('.c_instrucciones').addClass('d-block');
        })
        .on('mouseleave', () => {
            $('.c_instrucciones').removeClass('d-block');
        });
   
    
        
    // TITULO del grafico
    function renderTitulo() {
        let FtituloAnime = chart.selectAll('foreignObject.title')
            .data([info]);
        
        let enterF = FtituloAnime.enter()
            .append('foreignObject')
            .attr('class', 'title')
            .attr('y', 20)
            .attr('x', WIDTH/6)
            .attr('width', '50vw')
            .attr('height', '50px');

        enterF.append('xhtml:div')
            // .on('dblclick', function(event) {
            //     const elemento = $(this);
            //     const isEditable = elemento.attr('contenteditable') === true;
            //     if (!isEditable) {
            //         // Enter editing mode
            //         elemento.attr('contenteditable', 'true');
            //         elemento.focus();
            //     } else {
            //         // Exit editing mode
            //         elemento.attr('contenteditable', 'false');
            //     }
            // })
            // .on('keyup', function(event) {
            //     console.log("UNA: ", event.key);
            //     DATOSGENERALES[index]['INFO'].nombre =  $(this).text();
            //     localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
            // })
            .merge(FtituloAnime.select('div'))                
                .text((d) => d.nombre);
        
    }
    renderTitulo();
   
    // BOTON CONFIGURACION INFO ANIME

    chart.selectAll('text.config')
        .data([datos])
        .join('text')
        .attr('class', 'config')
        .attr('x', WIDTH-40)
        .attr('y', 45)
        .text('\uf013')
        .on('click', (event, d) => {
            configAnime.attr('value', d.INFO.nombre);
            configShowImage.attr('src', `media/animes/${d.INFO.logo}`);
            $('#myModalAnime').data('modalData', d);
            $('#myModalAnime').modal('show');
    });
   
    $('#myModalAnime').on('hidden.bs.modal', function() {
        renderTitulo();
    });
  

    // LEYENDA DEL EJE X
    chart
        .append('text')
        .attr('class', 'axis-label')
        .attr('y', HEIGHT - 15)
        .attr('x', WIDTH / 2)
        .attr('fill', 'black')
        .attr('text-anchor', 'middle')
        .text('EJE X');

    // LEYENDA EJE Y
    chart
        .append('text')
        .attr('class', 'axis-label')
        .attr('y', 25)
        .attr('x', -(HEIGHT) / 2)
        .attr('fill', 'black')
        .attr('text-anchor', 'middle')
        .attr('transform', 'rotate(-90)')
        .text('EJE Y');

    const yAxis = d3.axisLeft(yScale);
    
    const yAxisG = chart.selectAll('g.y-axis')
            .data([null])
            .join('g')            
            .attr('class', 'y-axis')
            .attr('transform', `translate(${MARGINS.left}, 0)`)
            .call(yAxis);

    // CREACION DE LAS LINEAS DE HORIZONTALES
    const gLineas = chart.append('g')
        .attr('class', 'g_lineas');
    gLineas.selectAll('line.horizontales')
        .data(d3.range(11))
        .join('line')
            .attr('class', 'horizontales')
            .attr('x1', MARGINS.left)
            .attr('y1', (d) => yScale(d))
            .attr('x2', WIDTH - MARGINS.right)
            .attr('y2', (d) => yScale(d))
            .attr('stroke', (d, i) => i === 0 ? '' : '#cecece');

    const xAxisG = chart.selectAll('g.x-axis')
        .data([null])
        .join('g')
        .attr('class', 'x-axis')
        .attr('transform', `translate(0, ${HEIGHT - MARGINS.bottom})`)
        .call(d3.axisBottom(xScale));

    const curveGeneration = d3.line();  
    curveGeneration.curve(d3.curveMonotoneX);
    

    const link = chart.append('g')
        .selectAll('path.conexion')
        .data(links)
        .join('path')
            .attr('class', 'conexion')
            .style('stroke', '#D5F0C1')
            .attr('fill', 'none');

    const regex1 = /[\d+](?=.png$)/;

    function calcularPromedio() {
        let sumatoria = data.reduce((a, b) => {
            return parseInt(a) + parseInt(b.value);
        }, 0);
        if (sumatoria > 0) {
            let promedio = formatPromedio(sumatoria / data.length); 
            return promedio
        }
        return 0;
    }
    // Valoracion Total del Anime
    const totalAnime = chart
        .append('text')
        .attr('x', 50)
        .attr('y', 70)
        .text(`Promedio: ${calcularPromedio()}`);


    // GENERAR EL GRAFICO
    function renderChart() {
        xAxisG.selectAll('text')
            .text((d, i) => `cap${i+1}`)
            .attr('dy', 15);

            
        // FIJAR LOS NODOS PARA QUE NO SE MUEVAN CON LA SIMULACION        
        data.forEach((node, i) => {
            node.fx = xScale(node.id);
            node.fy = yScale(node.value);
        });
        let gPuntaje = chart.selectAll('.g_puntaje')
            .data(data, d => d.id)
            .join(function(grupo) {
                let enter = grupo.append('g');
                enter.append('circle')
                .attr('r', 15)
                .attr('fill', '#43766C');
                enter.append('text')
                    .text(d => d.value)
                    .attr('text-anchor', 'middle')
                    .attr('dy', 5)
                    .attr('fill', 'white');
                return enter;
            }) 
                .attr('class', 'g_puntaje')
                .call(d3.drag()
                    .on('start', dragstarted)
                    .on('drag', dragged)
                    .on('end', dragended))
                .on('mouseenter', (event, d) => {
                    const [x, y] = d3.pointer(event, this);
                    console.log('Se llama a esto');
                    let xCoord = x + 20;
                    if (WIDTH - x < 200) {
                        xCoord = x - 200;
                    }                
                    tooltip
                        .style('top', `${y - 150}px`)
                        .style('left', `${xCoord}px`);                
                    titulo.text(`${d.titulo}`);
                    descripcion.text(`${d.descripcion}`);
                    imagen.attr('src', `media/episodios/${d.imagen}`);
                    $('#id_cap').val(d.id);
                    $('.tooltip1').addClass('d-block');
                        
                })
                .on('mouseleave', () => {                
                    $('.tooltip1').removeClass('d-block');
                })
                .on('dblclick', (event, d) => {
                    tituloCap.attr('value', d.titulo);
                    descripcionCap.attr('value', d.descripcion);
                    // inputImagen.attr('value', d.imagen);
                    showImagen.attr('src', `media/episodios/${d.imagen}`);
                    $('#myModalCapitulo').data('modalData', d);
                    $('#myModalCapitulo').modal('show');
                })
                .on('contextmenu', function(event, d) {
                    event.preventDefault();
                    alert_action("Advertencia", "Esta seguro de eliminar este capitulo?", function(){
                        eliminarEpisodio(d.id);
                        // data = datos['NODOS'].filter((item) => item.id !== d.id);
                        // chart.selectAll('.g_puntaje').data(data, (d) => d.id).exit().remove();
                        // xScale.domain(data.map((d) => d.id));
                        // xAxisG.call(d3.axisBottom(xScale));                                     
                        // DATOSGENERALES[index]['NODOS'] = data;

                        // localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));

                        // $('.tooltip1').removeClass('d-block');
                        // renderChart();
                    }, function() {
                        // Accion cuando se cancela la aparicion del cuadro de dialogo
                    });    
        
                });
                
            
        function conexiones() {            
            const simulation = d3.forceSimulation(data)
                .force('link', d3.forceLink(links)   
                    .id(d => d.id)           
                .distance(100)
            );          
            simulation
                .nodes(data)            
                .force('tick', ticked)
                .alphaDecay(0);
            
            simulation.force('link')
                .links(links);
    
            function ticked() {           
                gPuntaje
                    .attr('transform', (d) => {                 
                        return `translate(${d.x}, ${d.y})`;
                    });                 
            }
        
        }  
        conexiones();
        graficarLinks();   
        totalAnime.text(`Promedio: ${calcularPromedio()}`);   
    }
    renderChart();

    function graficarLinks() {
        let coordArray = [];
            data.forEach((item, i) => {
                coordArray.push([item.x, item.y]);
               
           });
           link
            .attr('d', function(d) {
                return curveGeneration(coordArray);
            });
                
    }
    
    function dragstarted(event, d) {
        d3.select(this).raise().classed("active", true);
        // console.log("NODO INICIAL: ", event);
    }

    let cambioValor = false;
    function dragged(event, d) {
        if (event.y > MARGINS.top && event.y < HEIGHT - MARGINS.bottom) {
            graficarLinks();
            // d.fx = event.x;
            // console.log("EVENTO: ", event);
            d.fy = event.y;
            let newValue = Math.round(yScale.invert(event.y));            
            if(d.value !== newValue) {
                d.value = newValue;
                cambioValor = true;
                let x = d3.select(this);
                let rect = x.select('text');
                rect.text(d.value);
                // localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
                totalAnime.text(`Promedio: ${calcularPromedio()}`);
                // console.log(`EVNET Y: ${event.y} ESCALA Y: ${yScale(d.value)}`);
                // console.log("SE MUEVE BUEN ", d);
            }
        }    
    }

    function dragended(event, d) {
        d3.select(this).classed("active", false);
        if (cambioValor) {
            console.log("NODO FINAL: ", d);
            actualizarValor(d.id, d.value);
            cambioValor = false;
        }
    }

    
    function crearApuntador() {
        
        const apuntador = svg.append('circle')
            .attr('r', 0)
            .attr('fill', 'stellblue')
            .style('stroke', 'white')
            .attr('opacity', .70)
            .style('pointer-events', 'none');
        const listeningRect = svg.append('rect')
            .attr('width', WIDTH-MARGINS.right)
            .attr('height', HEIGHT-MARGINS.bottom)
            .attr('x', MARGINS.left)
            .attr('y', MARGINS.top)
            .attr('fill', 'transparent')
            .on('mousemove', scalePointPosition)
            .on('mouseleave', function() {
                tooltip.style('display', 'none');
            })
            .raise();  

        function scalePointPosition(event) {
            var xPos = d3.pointer(event, this)[0];
            var domain = xScale.domain();
            var range = xScale.range();
            var rangePoints = d3.range(range[0], range[1], xScale.step())
            var yPos = domain[d3.bisect(rangePoints, xPos) - 1];
            console.log(yPos);
            tooltip 
                .style('display', 'block')
                .style('left', `${xPos}px`)
                .style('top', `${200}px`);
        }
    }

    
    
}   

function eliminarEpisodio(episodioId) {
    $.ajax({
        url: 'funciones/episodio-add.php',
        type: 'POST',
        data: {
            'action': 'eliminar_episodio',
            'id_episodio': episodioId,
        },
        success: function(response) {
            console.log("RESPONSE: ", response);
            buscarSeries();
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function eliminarSerie(serieId) {
    $.ajax({
        url: 'funciones/serie-add.php',
        type: 'POST',
        data: {
            'action': 'eliminar_serie',
            'id_serie': serieId,
        },
        success: function(response) {
            console.log("RESPONSE: ", response);
            buscarSeries();
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function actualizarValor(episodioId, newValue) {
    $.ajax({
        url: 'funciones/episodio-add.php',
        type: 'POST',
        data: {
            'episodioId': episodioId,
            'valor': newValue,
        },
        success: function(response) {
            console.log("RESPONSE: ", response);
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function actualizarInfoEpisodio(datos) {
    datos.append('action', 'actualizar_info');
    console.log("INFO ", datos);
    $.ajax({
        url: 'funciones/episodio-add.php',
        type: 'POST',
        data: datos, // Ensure 'datos' is a FormData object
        processData: false,
        contentType: false, // Ensure jQuery does not set content type
        success: function(response) {
            if (response === '0') {
                alert("La imagen excede los 10MB permitidos");
            } else {
                console.log("RESPONSE INFO: ", response);
                buscarSeries();
            }
            
            // buscarSeries();
            // mainGrafico();
        }, 
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}

function buscarSeries() {
    // OJO: url: -> comienza a buscar desde la carpeta raiz del proyecto, No desde donde estas!
    $.ajax({
        url: 'funciones/serie-list.php',
        type: 'GET',
        data: {
            'page': 1,
        },
        success: function(response) {
            console.log("SERIES: ", response);
            DATOSGENERALES = response;
            $('.labelNumAnimes').text(`Animes Calificados: ${DATOSGENERALES.length}`);
            mainGrafico();
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function agregarEpisodio(serieId) {
    $.ajax({
        url: 'funciones/episodio-add.php',
        type: 'POST',
        data: {
            'serieId': serieId,
            'action': 'agregar_episodio',
        },
        success: function(response) {
            console.log("RESPONSE: ", response);
            buscarSeries();
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function actualizarInfoAnime(datos) {
    datos.append('action', 'actualizar_anime');
    $.ajax({
        url: 'funciones/serie-add.php',
        type: 'POST',
        data: datos, // Ensure 'datos' is a FormData object
        processData: false,
        contentType: false, // Ensure jQuery does not set content type
        success: function(response) {
            console.log("RESPONSE INFO: ", response);
            buscarSeries();
            // mainGrafico();
        }, 
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}

$(function () {

    let newBread = $('<li>').addClass('breadcrumb-item active');
    newBread.text('Administracion de Series');
    $('#lista_bread').append(newBread);

    consultarInfoCategoria();

    
    buscarSeries();
    // if (DATOSGENERALES.length > 0) {
    //     mainGrafico();
    // }
   
    // console.log('datos', JSON.stringify(DATOSGENERALES));
    $('form').on('submit', function (e) {
        e.preventDefault();
        let data = new FormData(this);
        data.append('action', 'registrar_anime');
        let DATOS = crearDatos(data);
        // mainGrafico();
        // generarGrafico(DATOSGENERALES);
    });

    // RECIBIR LOS DATOS PASADOS AL MODAL
    // $('#myModalCapitulo').on('show.bs.modal', function() {
    //     const modalData = $(this).data('modalData');
    // })

    $('#myModalCapitulo').on('hidden.bs.modal', function() {
        // const modalData = $(this).data('modalData');
        $('#dataCap')[0].reset();
    })

    $('.btnGuardarInfoCap').on('click', function(e) {
        e.preventDefault();
        const formularioCap = document.getElementById('dataCap');
        let parameters = new FormData(formularioCap);
        const modalData = $('#myModalCapitulo').data('modalData');
        modalData.titulo = parameters.get('titulo');
        modalData.descripcion = parameters.get('descripcion');
        if (parameters.get('imagen')) {
            modalData.imagen = parameters.get('imagen');
        } else {
            modalData.imagen = 'img/img2.png';
        }
        actualizarInfoEpisodio(parameters);
        // localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
        $('#myModalCapitulo').modal('hide');
    });
    

    // LIMPIAR LA URL DE LA IMAGEN
    $('.btnLimpiarUrl').on('click', function() {
        $('#id-imagen-cap').val('');
    });

    $('.btnVerResultados').on('click', function() {
        calcularResultados();
    });

    $('.btnLimpiarLogo').on('click', function() {
        $('#id_logo').val('');
    });

    $('.btnLimpiarConfigLogo').on('click', function() {
        $('#id-config-logo').val('');
    });

    $('#myModalAnime').on('hidden.bs.modal', function() {
        $('#dataConfig')[0].reset();
    });

    $('.btnGuardarInfoAnime').on('click', function(e) {
        e.preventDefault();
        const formConfigAnime = document.getElementById('dataConfig');
        let parameters = new FormData(formConfigAnime);
        const modalData = $('#myModalAnime').data('modalData');
        modalData.INFO.nombre = parameters.get('config-anime');
        if (parameters.get('config-logo')) {
            modalData.INFO.logo = parameters.get('config-logo');
        } else {
            modalData.INFO.logo = 'img/img2.png';
        }
        parameters.append('id-anime', modalData.INFO.id);
        actualizarInfoAnime(parameters);
        // localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
        $('#myModalAnime').modal('hide');
    });

    $('.btnEliminarAnime').on('click', function(e) {
        e.preventDefault();
        alert_action("Advertencia", "Esta seguro de eliminar este anime?", function() {
            const modalData = $('#myModalAnime').data('modalData');
            eliminarSerie(modalData.INFO.id);
            $('#myModalAnime').modal('hide');
        }, function() {

        });
    });
    // descargarSVG();

    $('.btnDownload').on('click', function(e) {
        e.preventDefault();
        descargarSVG();
    });

    $('.btnDescargarData').on('click', function(e) {
        e.preventDefault();
        downloadData();
    });

    // Subir data desde un archivo
    $('#id-subir-data').on('change', function(event) {
        event.preventDefault();
        alert_action("Confirmacion", "Esta seguro que quiere cargar este archivo?", function(){
            const fileInput = event.target;
        
            if (fileInput.files.length > 0) {
                const selectedFile = fileInput.files[0];
            
                if (selectedFile.type === 'application/json') {
                const reader = new FileReader();
            
                reader.onload = function (event) {
                    const fileContent = event.target.result;
                    // localStorage.setItem('calificaciones', fileContent);
                    // console.log('File content saved to localStorage:', fileContent);
                    subirData(fileContent);
                };
            
                reader.readAsText(selectedFile);
                } else {
                    alert('Please select a JSON file.');
                }
            } else {
                console.error('No file selected.');
            }        
        }, function() {
            // Accion cuando se cancela la aparicion del cuadro de dialogo
        });    

          

    });

    // Vista Previa del Logo del Anime
    configLogo.on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                configShowImage.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    inputImagen.on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                showImagen.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('.btn-config-categoria').on('click', function() {
        let dataModal = $('#myModalCategoria').data('modalData');
        $('#id-categoria').val(dataModal.id);
        $('#id-nombre-categoria').val(dataModal.nombre);
        $('#myModalCategoria').modal('show');
    });

    

    $('.btnGuardarInfoCategoria').on('click', function(e) {
        e.preventDefault();
        const configCategoria = document.getElementById('dataCategoria');
        let parameters = new FormData(configCategoria);
        parameters.append('action', 'actualizar_categoria');
        actualizarInfoCategoria(parameters);
        // localStorage.setItem('calificaciones', JSON.stringify(DATOSGENERALES));
        $('#myModalCategoria').modal('hide');
    });

    $('.btnEliminarCategoria').on('click', function(e) {
        e.preventDefault();
        alert_action("Advertencia", "Esta seguro de eliminar esta Categoria? Todas las Series y Episodios se Eliminaran conjuntamente", function() {
            const modalData = $('#myModalCategoria').data('modalData');
            eliminarCategoria(modalData.id);
            $('#myModalCategoria').modal('hide');
        }, function() {

        });
    });
});

function actualizarInfoCategoria(datos) {
    $('.btn-config-categoria').addClass('desactivar-div');
    $.ajax({
        url: 'funciones/categoria-list.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function(response) {
            let respuesta = JSON.parse(response);
            $('.btn-config-categoria').removeClass('desactivar-div');
            $('#titulo-categoria').text(respuesta['result'].nombre);
            $('#myModalCategoria').data('modalData', respuesta['result']);
        },
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}

function subirData(datos) {
    $.ajax({
        url: 'funciones/subir-data.php',
        type: 'POST',
        data: {
            'action': 'subir_data',
            'data': datos
        }, 
        success: function(response) {
            console.log("SUBIR DATA: ", response);
            buscarSeries();
        }, 
        error: function(xhr, status, error) {
            console.log("Request failed with status: " + status);
        }
    });
}

function descargarSVG() {
    // Get the SVG element
    // const svgElement = $('.contenedor-calificaciones').children('div:first-child:first-child'); // Replace 'yourSvgId' with the ID of your SVG element
    // const svgElement = $('.contenedor-grafico:eq(0)').children('svg');
    // const svgElement = document.querySelector('.contenedor-grafico > svg');

    const svgElement = document.getElementById('grafico-resultados');
    const svgCode = new XMLSerializer().serializeToString(svgElement);
   const blob = new Blob([svgCode], { type: 'image/svg+xml' });

   // Create a temporary link element to trigger the download
   const downloadLink = document.createElement('a');
   downloadLink.href = URL.createObjectURL(blob);
   downloadLink.download = 'my_svg_file.svg';

   // Trigger the download
   downloadLink.click();

    
}


function calcularResultados() {
    let resultados = []
    DATOSGENERALES.forEach((item, index) => {
        let sumatoria = item.NODOS.reduce((acc, b) => {
            return parseInt(acc) + parseInt(b.value);
        }, 0);
        let promedio = 0;
        if (sumatoria > 0) {
            promedio = formatPromedio(sumatoria / item.NODOS.length);
        }
        resultados.push({id: index, anime: item.INFO.nombre, logo: item.INFO.logo, promedio: promedio});
    });
    resultados.sort((a, b) => a.promedio - b.promedio);
    console.log("RSULTAODS: ", resultados);
    $('#myModalResultados').modal('show');
    generarGraficoResultados(resultados);
}

// const contResultados = d3.select('.c-resultados');
function generarGraficoResultados(dataR) {
    let WIDTH = window.innerWidth * 0.65;
    let HEIGHT = 100 * dataR.length + 60;
    

    const MARGINS = { top: 60, right: 100, bottom: 50, left: 200 };

    //  schemeAccent, set3  
    const color = d3.scaleOrdinal(d3.schemeSet3);
    // Option 1: give 2 color names, rango de colores entre los dos
    var rangoColor = d3.scaleLinear().domain([1,10])
        .range(["yellow", "rgb(28, 142, 0)"])

    // Option 2: Color brewer.
    // Necesario <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script> in your code!
    var rangoColor2 = d3.scaleSequential().domain([1,10])
        .interpolator(d3.interpolatePuRd);
    
    // Option 3: Viridis.
    // Necesario <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script> in your code!
    var rangoColor3 = d3.scaleSequential().domain([1,10])
        .interpolator(d3.interpolateViridis);



    const svgResult = d3.select('#grafico-resultados')
        .attr("width", WIDTH)
        .attr("height", HEIGHT)
        
    
    // svgResult.selectAll('*').remove();
    const gfondo = svgResult.selectAll('g.g-fondo-result')
        .data([HEIGHT])
        .join((enter) => {
            let grupo = enter.append('g');
            grupo.append('rect')
                .attr('width', WIDTH)
                .attr('height', HEIGHT)
                .attr('fill', '#FFFFFF');                
            grupo.append('text')
                .attr('class', 'titulo-result')
                .attr('dx', WIDTH/2)
                .attr('dy', 30)
                .style('font-size', '30px')
                .style('font-family', 'Arial')
                .attr('text-anchor', 'middle')                
                .text('Top 10 Best Animes of 2023');
            return grupo;
        })
        .attr('class', 'g-fondo-result')
        .attr('transform', `translate(0, 0)`);


    const chart = svgResult.selectAll('g.g-informacion')
        .data([null])
        .join('g')
        .attr('class', 'g-informacion');     

    const xScale = d3.scaleLinear().range([MARGINS.left, WIDTH - MARGINS.right]).domain([0, 10]);
    const yScale = d3.scalePoint().range([HEIGHT - MARGINS.bottom, MARGINS.top])
        .domain(dataR.map((d) => d.id)).padding(0.4);

    const yAxis = d3.axisLeft(yScale);
    const yAxisG = chart.selectAll('g.y-axis-result')
        .data([null])
        .join('g')
        .attr('class', 'y-axis-result')
        .attr('transform',  `translate(${MARGINS.left}, 0)`)
        .call(yAxis);
    
    const xAxisG = chart.selectAll('g.x-axis-result')
        .data([null])
        .join('g')
        .attr('class', 'x-axis-result')
        .attr('transform', `translate(0, ${HEIGHT - MARGINS.bottom})`)
        .call(d3.axisBottom(xScale));

    // Create SVG text elements with wrapping
    yAxisG.selectAll("text")
        .data(dataR)
        .attr('width', 140)                
        .style('font-size', '15px')        
        .text((d) => d.anime)
        .call(wrap); 


    // CREACION DE LAS BARRAS
    const gBarras = chart.selectAll('g.g-bar-result')
        .data(dataR, (d) => d.id);

    const enterG = gBarras.enter()
        .append('g')
        .attr('class', 'g-bar-result');

    enterG.merge(gBarras)
        .transition() // Example transition, adjust as needed
        .attr('transform', (d) => `translate(${MARGINS.left}, ${yScale(d.id) - 20})`);

    enterG.append('rect')
        .attr('height', 40)
        .attr('fill', (_, i) => color(i))
        .merge(gBarras.select('rect')) // Merge enter and update selections for 'rect'
        .transition() // Example transition, adjust as needed
        .attr('width', (d) => xScale(d.promedio) - MARGINS.left);

    enterG.append('text')
        .attr('dy', 25)
        .merge(gBarras.select('text')) // Merge enter and update selections for 'text'
        .text((d) => d.promedio)
        .transition() // Example transition, adjust as needed
        .attr('x', (d) => d.promedio < 0.75 ? 20 : xScale(d.promedio) - MARGINS.left - 40);

    enterG.append('image')
        .attr('class', 'logo-result')
        .attr('dy', 20)
        .attr('width', 80)
        .attr('height', 40)
        .merge(gBarras.select('image'))
        .attr('xlink:href', (d) => `http://localhost/Trabajos_PHP/Calificar_Series/media/animes/${d.logo}`)
        .transition()
        .attr('x', (d) => d.promedio < 0.75 ? MARGINS.right + 20 : xScale(d.promedio) - MARGINS.left + 20);
        

    // Exit selection
    gBarras.exit().remove();
}


function alert_action(title, content, callback, cancel) {
    $.confirm({
        theme: 'material',
        title: title,
        icon: 'fas fa-exclamation-triangle',
        content: content,
        columnClass: 'small',
        typeAnimated: true,
        cancelButtonClass: 'btn-primary',
        draggable: true,
        dragWindowBorder: false,
        buttons: {
            info: {
                text: "Si",
                btnClass: 'btn-primary',
                action: function () {
                    callback();
                }
            },
            danger: {
                text: "No",
                btnClass: 'btn-red',
                action: function () {
                    cancel();
                }
            },
        }
    })
}

function formatPromedio(promedio) {
    return ((promedio * 100) / 100).toFixed(2);
}

let heightLine = 0;
function wrap(text) {
    let marginLeft = 20;
    text.each(function() {
        let text = d3.select(this),
            words = text.text().split(/\s+/).reverse(),
            word,
            line = [],
            lineNumber = 0,
            lineHeight = 1.1,
            x = text.attr('x'),
            y = text.attr('y'),
            dy = 0,
            tspan = text.text(null)
                .append('tspan')
                .attr('x', x - marginLeft)
                // .attr('y', y)
                .attr('dy', dy + 'em');
            count = 0;
        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(' '));
            if (tspan.node().getComputedTextLength() > text.attr('width')) {
                line.pop();
                tspan.text(line.join(' '));
                line = [word];
                tspan = text.append('tspan')
                    .attr('x', - marginLeft)
                    // .attr('y', y)
                    .attr('dy', lineHeight + 'em')
                    .text(word);
                count++;
            }
        }
        let aux = text.selectAll('tspan').size();
        if (aux > heightLine) {
            heightLine = aux;
            console.log("TAMANIOC: ", count);
            // tspan.attr('dy', tspan.attr('dy') - 0.2 + 'em');
            text.attr('y', (count * -0.55) + 'em'); 
        }

    });
}

function downloadData() {
    // Retrieve data from localStorage
    const savedData = JSON.stringify(DATOSGENERALES);
  
    if (savedData) {
      // Create a Blob containing the data
      const blob = new Blob([savedData], { type: 'application/json' });
  
      // Create a temporary link element
      const downloadLink = document.createElement('a');
      downloadLink.href = URL.createObjectURL(blob);
      downloadLink.download = 'myData.json'; // Specify the filename and extension
  
      // Append the link to the body and trigger the download
      document.body.appendChild(downloadLink);
      downloadLink.click();
  
      // Clean up
      document.body.removeChild(downloadLink);
    } else {
      console.log('No data found in localStorage');
    }
  }
  


function consultarInfoCategoria() {
    $.ajax({
        url: 'funciones/categoria-list.php',
        type: 'GET',
        data: {
            'action': 'buscar_categoria',
        },
        success: function(response) {
            if (response[0]) {
                $('.btn-config-categoria').removeClass('desactivar-div');
                $('#titulo-categoria').text(response[0].nombre);
                $('#myModalCategoria').data('modalData', response[0]);                
                console.log("llego los datos del modal");
            }
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}

function eliminarCategoria(categoriaId) {
    $.ajax({
        url: 'funciones/categoria-list.php',
        type: 'POST',
        data: {
            'action': 'eliminar_categoria',
            'id_categoria': categoriaId,
        },
        success: function(response) {
            location.href = 'inicio.php';
        },
        error: function(xhr, status, error) {
            console.error("Request failed with status: " + status);
        }
    });
}