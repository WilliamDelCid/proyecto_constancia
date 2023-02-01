<?php cabecera($datos_vista);?>
<?php obtener_modal("modal_anexo_expediente", $datos_vista);?>

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

        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
              <?php if(empty($datos_vista['datos_generales']['foto_url'])){?>
                <img class="profile-user-img img-fluid img-circle" id="foto_expediente"
                      src="<?= url_base();?>/archivos/imagenes/avatar/1.png"
                      alt="<?= $datos_vista['datos_generales']['nombres'];?>">
              <?php } else{?>
                <img class="profile-user-img img-fluid img-circle" id="foto_expediente"
                      src="<?= url_base();?>/<?= $datos_vista['datos_generales']['foto_url'];?>"
                      alt="<?= $datos_vista['datos_generales']['nombres'];?>">
              <?php } ?>
              </div>

              <h3 class="profile-username text-center" id="nombre_expediente"><?= $datos_vista['datos_generales']['nombres'];?></h3>
              <h3 class="profile-username text-center" id="nombre_expediente"><?= $datos_vista['datos_generales']['apellidos'];?></h3>
              
              <p class="text-muted text-center"><?= obtener_edad_segun_fecha($datos_vista['datos_generales']['fecha_nacimiento']);?> años</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>N° Expediente</b> <div class="float-right"><?= $datos_vista['datos_generales']['codigo'];?></div>
                </li>
                <li class="list-group-item">
                  <b>Fecha de Nacimiento</b> <div class="float-right"><?= formatear_fecha($datos_vista['datos_generales']['fecha_nacimiento']);?></div>
                </li>
                <li class="list-group-item">
                  <b>Grupo de Edad</b> <div class="float-right"><?= $datos_vista['datos_generales']['grupo_edad'];?></div>
                </li>
                <li class="list-group-item">
                  <b>Género</b> <div class="float-right"><?php if($datos_vista['datos_generales']['genero'] == 1){echo "Masculino";}else{echo "Femenino";}?></div>
                </li>
                <li class="list-group-item">
                  <b>Turno</b> <div class="float-right"><?php if($datos_vista['datos_generales']['turno'] == 1){echo "AM";}else{echo "PM";}?></div>
                </li>
                <li class="list-group-item">
                  <b>Horario</b> <div class="float-right"><?= $datos_vista['datos_generales']['horario'];?></div>
                </li>
                <li class="list-group-item">
                  <b>Tutor</b> <div class="float-right"><?= $datos_vista['datos_generales']['tutor'];?></div>
                </li>
              </ul>

              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          
        </div>
        <!-- /.col-md-3 -->

        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills" id="nav-tabs-areas">
                <?= $datos_vista['nav_tabs_areas'];?>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <input type="hidden" id="id_expediente" name="id_expediente" value="<?= $datos_vista['id_expediente'];?>">
              <div class="tab-content">
                <input type="hidden" id="inicializaciondetablas" name="inicializaciondetablas" value="<?= $datos_vista['inicializacion_de_tablas'];?>">
                <?= $datos_vista['div_tab_por_area'];?>
                
                
                
              </div>
              <!-- /.tab-content -->
              
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php piepagina($datos_vista); ?>
