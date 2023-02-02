<?php cabecera($datos_vista); ?>
<!-- <?php obtener_modal("modal_formularios", $datos_vista); ?> -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin-top: 80px">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $datos_vista['titulo_pagina']; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= url_base(); ?>/inicio">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $datos_vista['titulo_pagina']; ?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-body">
              <form id="formFormulario" name="formFormulario">
                <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="">
                  <p class="text-<?= COLOR_SIDEBAR_ACTIVO ?>">Todos los campos son obligatorios.</p>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Nombres</label>
                        <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre del participante">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Apellidos</label>
                        <input class="form-control" id="apellido" name="apellido" type="text" placeholder="Apellido del participante">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="cargo">Tipo de participación</label>
                        <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="participacion" name="participacion" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required="" style="width: 100%;">
                        </select>
                      </div>
                      <div id="invalid-cargo" class="error"></div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal" style="display: grid; place-items: center; margin:30px 0px  0px; width: 50px; height: 40px;"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="cargo">Nombre del evento</label>
                        <select class="form-control select2 select2-<?= COLOR_SIDEBAR_ACTIVO ?>" id="evento" name="evento" data-dropdown-css-class="select2-<?= COLOR_SIDEBAR_ACTIVO ?>" required="" style="width: 100%;">
                        </select>
                      </div>
                      <div id="invalid-cargo" class="error"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Nombre del evento (Opcional) </label>
                        <input class="form-control" id="evento_opcional" name="evento_opcional" type="text" placeholder="Nombre del evento">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Fecha del evento</label>
                        <input class="form-control" type="text" id="fecha_evento" name="fecha_evento" />
                      </div>
                    </div>
                  </div>
                  <div class=" row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Lugar del evento</label>
                        <input class="form-control" id="lugar_evento" name="lugar_evento" type="text" placeholder="Lugar del evento">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Fecha de expedición</label>
                        <input id="fecha_expedicion" name="fecha_expedicion" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" />
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
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
    </div>
</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php piepagina($datos_vista); ?>