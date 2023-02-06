<div class="modal fade" id="modal_usuarios" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #004A98; color:#fff;">
        <h5 class="modal-title" id="titulo_modal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formUsuarios" name="formUsuarios">
        <div class="modal-body">
          <input type="hidden" id="id" name="id" value="">

          <p class="text-<?= COLOR_SIDEBAR_ACTIVO ?>">Todos los campos con (*) son obligatorios.</p>


          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label">Correo Electrónico *</label>
                <input class="form-control" id="email" name="email" type="email" placeholder="Correo" required="">
                <div id="invalid-email" class="error"></div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button class="btn bg-<?= COLOR_SIDEBAR_ACTIVO ?>" type="button" onclick="ver_contraseña()"><i class="fas fa-eye"></i></button>
                  </div>
                  <input type="password" class="form-control" id="password" name="password" maxlength="20" autocomplete="off">
                </div>
                <div id="invalid-password" class="error"></div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="estado">Empleado *</label>
                <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="empleado" name="empleado" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required="" style="width: 100%;">
                </select>
              </div>
              <div id="invalid-empleado" class="error"></div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="rol">Rol *</label>
                <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="rol" name="rol" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required="" style="width: 100%;">
                </select>
                <div id="invalid-rol" class="error"></div>
              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-sm-6">
              <div class="form-group">
                <label for="estado">Estado *</label>
                <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="estado" name="estado" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required="" style="width: 100%;">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <div id="invalid-estado" class="error"></div>
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