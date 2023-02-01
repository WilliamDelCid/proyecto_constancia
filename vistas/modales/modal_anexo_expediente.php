
<div class="modal fade" id="modal_anexo_expediente" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Nuevo Anexo al Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formAnexoExpediente" name="formAnexoExpediente">
        <div class="modal-body">
            <input type="hidden" id="idanexo" name="idanexo" value="">
            <input type="hidden" id="idarea" name="idarea" value="">
            <input type="hidden" id="idarea_expediente" name="idarea_expediente" value="">

            <p class="text-<?= COLOR_SIDEBAR_ACTIVO ?>">Todos los campos con (*) son obligatorios.</p>


            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="estado">Anexo *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="apartado_area" name="apartado_area" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  style="width: 100%;">
                    </select>
                </div>
                <div id="invalid-apartado_area" class="error"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Titulo *</label>
                  <input class="form-control" id="titulo" name="titulo" type="text" placeholder="Ingrese el título del anexo" required="">
                  <div id="invalid-titulo" class="error"></div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Descripción *</label>
                  <textarea class="form-control" rows="3" cols="12" id="descripcion" name="descripcion"  placeholder="Ingrese la descripción del anexo" required=""></textarea>
                  <div id="invalid-descripcion" class="error"></div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Fecha *</label>
                  <input class="form-control" id="fecha" name="fecha" type="date" required="">
                  <div id="invalid-fecha" class="error"></div>
                </div>
              </div>
            </div>

            
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn bg-<?= COLOR_SIDEBAR_ACTIVO ?>">Siguiente</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_anexo_expediente_imagenes" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Ingrese las imágenes y/o PDFs del Anexo al Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formAnexoExpedienteImagenes" name="formAnexoExpedienteImagenes">
        <div class="modal-body">
            <input type="hidden" id="id_det_expediente_creado" name="id_det_expediente_creado" value="">

            
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Imágenes y Archivos PDF (válidos JPG, JPEG, PNG y PDF 2Mb máximo)</label>
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                  <div id="actions" class="row">
                      <div class="col-lg-7">
                          <!-- The fileinput-button span is used to style the file input field as button -->
                          <span class="btn btn-danger fileinput-button">
                              <i class="glyphicon glyphicon-plus"></i>
                              <span>Agregar Imagen/PDF...</span>
                          </span>
                          <button type="submit" class="btn btn-primary start" style="display: none;">
                              <i class="glyphicon glyphicon-upload"></i>
                              <span>Start upload</span>
                          </button>
                          <button type="reset" class="btn btn-warning cancel" style="display: none;">
                              <i class="glyphicon glyphicon-ban-circle"></i>
                              <span>Cancel upload</span>
                          </button>
                      </div>
              
                      <div class="col-lg-5">
                          <!-- The global file processing state -->
                          <span class="fileupload-process">
                              <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                  <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                              </div>
                          </span>
                      </div>
                  </div>
              
                  <div class="table table-striped files" id="previews">
                      <div id="template" class="file-row row">
                          <!-- This is used as the file preview template -->
                          <div class="col-xs-12 col-lg-3">
                              <span class="preview" style="width:160px;height:160px;">
                                  <img data-dz-thumbnail />
                              </span>
                              <br/>
                              <button class="btn btn-primary start" style="display:none;">
                                  <i class="glyphicon glyphicon-upload"></i>
                                  <span>Empezar</span>
                              </button>
                              <button data-dz-remove class="btn btn-warning cancel">
                                  <i class="icon-ban-circle fa fa-ban-circle"></i> 
                                  <span>Cancelar</span>
                              </button>
                              <button data-dz-remove class="btn btn-danger delete">
                                  <i class="icon-trash fa fa-trash"></i> 
                                  <span>Eliminar</span>
                              </button>
                          </div>
                          <div class="col-xs-12 col-lg-9">
                              <p class="name" data-dz-name></p>
                              <p class="size" data-dz-size></p>
                              <div>
                                  <strong class="error text-danger" data-dz-errormessage></strong>
                              </div>
                              <div>
                                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              
                  <div class="dropzone-here">Agregue archivos aquí.</div>
                </div>
              </div>
            </div>
        
            
           
            

          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
          
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_ver_anexo_expediente_imagenes" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Anexo de Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     
        <div class="modal-body">
            <input type="hidden" id="id_ver_det_expediente_creado" name="id_ver_det_expediente_creado" value="">

            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <label class="control-label">Fecha</label>
                  <p id="verfecha"></p>
                </div>
              </div>
              <div class="col-sm-9">
                <div class="form-group">
                  <label class="control-label">Titulo</label>
                  <p id="vertitulo"></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Descripción</label>
                  <p id="verdescripcion"></p>
                </div>
              </div>
            </div>

            

             <!-- carousel start -->
             <div class="row">
              <div class="col-sm-12">
                <label class="control-label">Fotografías</label>
                <div id="imagenes_carrusel">

                </div>
                
              </div>
            </div>
            <!-- carousel end -->
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
          
        </div>
      
    </div>
  </div>
</div>