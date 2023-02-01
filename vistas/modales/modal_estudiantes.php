<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.dataTables.min.css"> 
<div class="modal fade" id="modal_estudiantes" tabindex="-1" role="dialog" aria-hidden="true">
 
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Nueva Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formEstudiantes" name="formEstudiantes">
        <div class="form__grid">
<!-- Form -->
  
      <div class="modal-body form__inputs">
        <input type="hidden" id="id" name="id" value="">
          <div class="col-sm-10">
              <label class="control-label">Nombre de la Actividad</label>
              <input class="form-control" id="nombre_actividad" name="nombre_actividad" type="text" placeholder="Nombre de la Actividad" >
          </div>
          <div class="col-sm-10">
              <label class="control-label">Descripción de la Actividad</label>
              <textarea class="form-control" id="descripcion_actividad" name="descripcion_actividad" type="text" placeholder="Descripción de la Actividad"  ></textarea>
          </div>
          <div class="col-sm-6 "> 
              <label class="control-label">Presupuesto</label>
              <input class="form-control"  step="any" id="presupuesto" name="presupuesto" type="number" placeholder="Presupuesto"  >
          </div>
          <div class="col-sm-8">
                <div class="form-group">
                    <label for="estado">Area *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="area" name="area" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  >
                    </select>
                </div>
                <div id="invalid-empleado" class="error"></div>
          </div>
          <div class="col-sm-8">
                <div class="form-group">
                    <label for="estado">Empleado *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="empleado" name="empleado" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  >
                    </select>
                </div>
                <div id="invalid-empleado" class="error"></div>
          </div>

        </div>

<!-- Form -->
  <!-- Table -->
  <div class="row" style="padding:10px 10px 0px;">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            
            <div class="card-body">
              <?php if(isset($_SESSION['permisos_'.nombreproyecto()]['Crear Roles'])){ ?>
                <button id="btn_nuevo_rol" type="button" class="btn btn-<?= COLOR_SIDEBAR_ACTIVO; ?>"><i class="fas fa-plus"></i> Nuevo rol</button>
              
              <br>
              <br>
              <?php } ?>
              <div class="table-responsive">
                  <table style="width: 100%" class="table align-items-center table-flush table-hover dataTable estilito" id="tabla_roles">
                    <thead>
                      <tr>  
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                        
                      </tr>
                    </thead>
                    <tbody id="datos_tabla">
                        
                    </tbody>
                  </table>
                </div>
            </div>
            <!-- /.card-body -->
            
          </div>
          <!-- /.card -->
        </div>
      </div>
<!-- Table -->

</div>
        <div class="modal-footer">
        <button type="button" id="boton">Finalizar Actividad</button>
        <button type="submit" class="btn bg-<?= COLOR_SIDEBAR_ACTIVO ?>">Guardar</button>
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>