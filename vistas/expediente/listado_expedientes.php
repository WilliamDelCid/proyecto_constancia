<?php cabecera($datos_vista);?>
<?php obtener_modal("modal_expediente", $datos_vista);?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $datos_vista['titulo_pagina'];?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= url_base();?>/inicio">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $datos_vista['titulo_pagina'];?></li>
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
              <?php if(isset($_SESSION['permisos_'.nombreproyecto()]['Crear Expediente'])){ ?>
                <button id="btn_nuevo_expediente" type="button" class="btn btn-<?= COLOR_SIDEBAR_ACTIVO; ?>"><i class="fas fa-plus"></i> Nuevo Expediente</button>
              
              <br>
              <br>
              <?php } ?>
              
              <div class="table-responsive">
                <table class="table align-items-center table-flush table-hover dataTable" id="tabla_expedientes">
                  <thead>
                    <tr>  
                      <th>Codigo</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Estado</th>
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
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php piepagina($datos_vista); ?>