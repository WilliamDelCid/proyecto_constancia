
<div class="modal fade" id="modal_expediente" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Nuevo Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formExpediente" name="formExpediente">
        <div class="modal-body">
            <input type="hidden" id="id" name="id" value="">

            <p class="text-<?= COLOR_SIDEBAR_ACTIVO ?>">Todos los campos con (*) son obligatorios.</p>


            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label">Codigo *</label>
                  <input class="form-control" id="codigo" name="codigo" type="text" placeholder="ES079700644" required="">
                  <div id="invalid-codigo" class="error"></div>
                </div>
              </div>

              <div class="col-sm-5">
                <div class="form-group">
                  <label class="control-label">Nombres *</label>
                  <input class="form-control" id="nombres" name="nombres" type="text" placeholder="Nombres del niño/a" required="">
                  <div id="invalid-nombres" class="error"></div>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="form-group">
                  <label class="control-label">Apellidos *</label>
                  <input class="form-control" id="apellidos" name="apellidos" type="text" placeholder="Apellidos del niño/a" required="">
                  <div id="invalid-apellidos" class="error"></div>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Fecha de nacimiento *</label>
                  <input class="form-control" id="fechanac" name="fechanac" type="date" placeholder="Fecha nac" required="">
                  <div id="invalid-fechanac" class="error"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Edad *</label>
                  <input class="form-control" id="edad" name="edad" type="text" placeholder="" required="" readonly>
                  <div id="invalid-edad" class="error"></div>
                </div>
              </div>
              

             

            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label class="control-label">Grupo de edad *</label>
                  <input class="form-control" id="grupo_edad" name="grupo_edad" type="text" placeholder="2-5" required="">
                  <div id="invalid-grupo_edad" class="error"></div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label for="estado">Genero *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="genero" name="genero" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  style="width: 100%;">
                        <option value="1">Masculino</option>
                        <option value="2">Femenino</option>
                    </select>
                </div>
                <div id="invalid-genero" class="error"></div>
              </div>

            </div>

            <div class="row">

             
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="estado">Turno *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="turno" name="turno" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  style="width: 100%;">
                        <option value="1">AM</option>
                        <option value="2">PM</option>
                    </select>
                </div>
                <div id="invalid-turno" class="error"></div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label>Fotografía (válidos JPG, JPEG, PNG)</label>
                  <br><input  id="foto_exp" name="foto_exp" type="file"><br>
                  <div id="invalid-foto_exp" class="error"></div>
                </div>
              </div>
              

            </div>
            
            <div class="row">

             
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="estado">Tutora *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="tutor" name="tutor" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  style="width: 100%;">
                    </select>
                </div>
                <div id="invalid-tutor" class="error"></div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="estado" name="estado" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required=""  style="width: 100%;">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
                <div id="invalid-estado" class="error"></div>
              </div>
              

            </div>

            <div class="row">

             
              <div class="col-sm-12">
                <label for="estado">Horario *</label>
                <div class="form-group row justify-content-center">
                  
                  
                  <div class="form-check col-sm-2">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="1" id="lunes" name="lunes">Lunes
                    </label>
                  </div>
                  <div class="form-check col-sm-2">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="1" id="martes" name="martes">Martes
                    </label>
                  </div>
                  <div class="form-check col-sm-2">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="1" id="miercoles" name="miercoles">Miércoles
                    </label>
                  </div>
                  <div class="form-check col-sm-2">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="1" id="jueves" name="jueves">Jueves
                    </label>
                  </div>
                  <div class="form-check col-sm-2">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" value="1" id="viernes" name="viernes">Viernes
                    </label>
                  </div>

                </div>
                
              </div>

              

            </div>
            

          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn bg-<?= COLOR_SIDEBAR_ACTIVO ?>">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>