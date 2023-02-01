<?php cabecera($datos_vista);?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $datos_vista['titulo_ventana'];?></h1>
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
      <div class="error-page">
        <h2 class="headline text-warning"> <i class="fas fa-exclamation-triangle text-warning"></i></h2>
		<br>
        <div class="error-content">
          
			
          <p>
          <?= $datos_vista['mensaje_pagina'];?>
          <br>Regrese a la <a href="<?= url_base(); ?>/inicio"> página principal</a>.
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php piepagina($datos_vista); ?>