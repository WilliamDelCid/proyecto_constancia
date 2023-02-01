
<div class="modal fade" id="modal_cargos" role="dialog" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="titulo_modal">Nuevo Cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="formCargo" name="formCargo">
        <div class="modal-body">
        <input type="hidden" id="id" name="id" value="">
        <p class="text-<?= COLOR_SIDEBAR_ACTIVO ?>">Todos los campos son obligatorios.</p>
          <div class="form-group">
              <label class="control-label">Nombre</label>
              <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre del cargo">
          </div>
          <div class="form-group">
              <label for="estado">Estado</label>
              <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="estado" name="estado" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" style="width: 100%;">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
              </select>
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