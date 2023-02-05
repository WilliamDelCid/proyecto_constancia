<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $datos_vista['titulo_pagina']; ?></title>
  <!-- <link rel="shortcut icon" href="<?= url_base(); ?>/archivos/imagenes/logotaber.png"> -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Sweetalert -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/adminlte/css/adminlte.min.css">
  <!-- Estilo loading -->
  <link href="<?= url_base(); ?>/archivos/css/cargando.css" rel="stylesheet" />
  <!-- Estilos generales -->
  <link href="<?= url_base(); ?>/archivos/css/estilos_generales.css" rel="stylesheet" />
</head>
<div id="div_cargando">
  <div>
    <img src="<?= url_base(); ?>/archivos/imagenes/cargando/cargando.svg" alt="Cargando...">
  </div>
</div>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card">

      <div class="card-body login-card-body text-center">
        <img src="<?= url_base(); ?>/archivos/imagenes/SR.png" alt="" style="margin-bottom: 25px;" height="50" width="100%">
        <br><br>

        <form id="formLogin">
          <div class="input-group mb-4">
            <input type="email" class="form-control" placeholder="Correo electrónico" id="txt_email" name="txt_email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Contraseña" id="txt_pass" name="txt_pass">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-2">

            </div>
            <!-- /.col -->
            <div class="col-8">
              <button type="submit" class="btn btn-danger btn-block mt-3">INICIAR SESIÓN</button>
            </div>
            <!-- /.col -->
            <div class="col-2">

            </div>
          </div>
        </form>
        <!-- /.login-card-body -->
        <br>

      </div>
    </div>
    <!-- /.login-box -->
    <script>
      const url_base = "<?= url_base(); ?>";
      const imagenes_alertas = "<?= imagenes_alertas(); ?>";
      const imagenes_botones = "<?= imagenes_botones(); ?>";
    </script>
    <script src="<?= url_base(); ?>/funciones/js_generales.js"></script>
    <script src="<?= url_base(); ?>/funciones/<?= $datos_vista['archivo_funciones']; ?>"></script>
    <!-- jQuery -->
    <script src="<?= url_base(); ?>/template/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= url_base(); ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Sweetalert -->
    <script src="<?= url_base(); ?>/template/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= url_base(); ?>/template/plugins/adminlte/js/adminlte.min.js"></script>
</body>

</html>