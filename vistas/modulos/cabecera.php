<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $datos_vista['titulo_ventana']; ?></title>
  <link rel="shortcut icon" href="<?= url_base(); ?>/archivos/imagenes/logotaber.png">
  <!-- Google Font: Source Sans Pro -->
  <!-- Font Awesome -->
  <style>
    .ui-state-highlight {
      border: 0 !important;
    }

    .ui-state-highlight a {
      background: #363636 !important;
      color: #fff !important;
    }
  </style>
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/select2/css/select2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Sweetalert -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Dropzone -->


  <!-- Datatables -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


  <!-- Theme style -->
  <!-- Estilo loading -->
  <link href="<?= url_base(); ?>/archivos/css/cargando.css" rel="stylesheet" />
  <!-- Estilos generales -->
  <link href="<?= url_base(); ?>/archivos/css/estilos_generales.css" rel="stylesheet" />
  <!-- Estilos dropzone -->
  <link href="<?= url_base(); ?>/archivos/css/estilos_dropzone.css" rel="stylesheet" />
  <link href="<?= url_base(); ?>/Horizontal/public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= url_base(); ?>/Horizontal/public/assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?= url_base(); ?>/Horizontal/public/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body style="padding-bottom: 0px;" class="hold-transition sidebar-mini layout-fixed <?= COLOR_TEMA ?>">
  <div id="div_cargando">
    <div>
      <img src="<?= url_base(); ?>/archivos/imagenes/cargando/cargando.svg" alt="Cargando...">
    </div>
  </div>
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php barra_horizontal($datos_vista); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php menu_lateral($datos_vista); ?>