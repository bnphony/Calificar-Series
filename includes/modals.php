  <!-- MODAL CAPITULO INFO -->
  <div class="modal fade" id="myModalCapitulo" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <b><i class="fas fa-search"></i> Editar Informacion del Capitulo </b>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">                            
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="dataCap" action="." method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_capitulo" id="id_cap" value="0">
                            <div class="mb-3 row">
                                <label for="titulo-cap" class="col-sm-2 col-form-label">Titulo</label>
                                <div class="col-sm-10">
                                  <input type="text" name="titulo" class="form-control" id="titulo-cap" placeholder="Ingrese el Titulo del Capitulo">
                                </div>
                            </div>                       
                            <div class="mb-3 row">
                                <label for="id-imagen-cap" class="col-sm-2 col-form-label">Subir Imagen</label>
                                <div class="col-sm-10 d-flex">
                                  <input type="file" name="imagen" accept="image/*" class="form-control" id="id-imagen-cap">
                                </div>
                                <div class="col-sm-12 mt-3">
                                  <label>Imagen Actual: </label>
                                  <img src="img/img2.png" loading="lazy" id="show-imagen">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="descripcion-cap" class="col-sm-2 col-form-label">Descripcion</label>
                                <div class="col-sm-10">
                                  <input type="text" name="descripcion" class="form-control" id="descripcion-cap" placeholder="Ingrese la Descripcion del Capitulo">
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btnGuardarInfoCap">Guardar Informacion</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL ELIMINACION -->
        <div class="modal" id="myModalEliminacion" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>

          <!-- MODAL RESULTADOS -->
        <div class="modal" id="myModalResultados" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Resultados</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="c-resultados">
                        <svg id="grafico-resultados">
    
                        </svg>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-flat btn-success btnDownload">Descargar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- MODAL CONFIG ANIME -->
          <div class="modal fade" id="myModalAnime" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <b><i class="fas fa-search"></i>Editar Información del Capítulo </b>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">                            
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="dataConfig" action="." method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_capitulo" id="id_cap" value="0">
                            <div class="mb-3 row">
                                <label for="id-config-anime" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                  <input type="text" name="config-anime" class="form-control" id="id-config-anime" placeholder="Ingrese el nombre del Anime">
                                </div>
                            </div>                       
                            <div class="mb-3 row">
                                <label for="id-config-logo" class="col-sm-2 col-form-label">Logo Anime</label>
                                <div class="col-sm-10 d-flex">
                                  <input type="file" name="config-logo" accept="image/*" class="form-control" id="id-config-logo">                                  
                                </div>
                                <div class="col-sm-12 mt-3">
                                  <label>Logo Actual: </label>
                                  <img src="img/img2.png" loading="lazy" id="config-show-image">
                                </div>
                                
                            </div>
                        </form>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning me-auto btnEliminarAnime">Eliminar Anime</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btnGuardarInfoAnime">Actualizar Informacion</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CONFIG CATEGORIA -->
        <div class="modal fade" id="myModalCategoria" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Actualizar Informacion de la Categoria</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="dataCategoria" action="." method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_categoria" id="id-categoria" value="0">
                    <div class="mb-3 row">
                        <label for="id-nombre-categoria" class="col-sm-2 col-form-label">Nombre Categoria</label>
                        <div class="col-sm-10">
                          <input type="text" name="nombre_categoria" class="form-control" id="id-nombre-categoria" placeholder="Ingrese el nombre de la Categoria">
                        </div>
                    </div>                       
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning me-auto btnEliminarCategoria">Eliminar Categoria</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary btnGuardarInfoCategoria">Actualizar Informacion</button>
                </div>
              </div>
            </div>
          </div>