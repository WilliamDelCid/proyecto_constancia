<?php cabecera($datos_vista);
obtener_modal("modal_estudiantes", $datos_vista);
obtener_modal("modal_roles", $datos_vista);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Global Styles -->
  <link rel="stylesheet" href="<?= url_base(); ?>/archivos/css/styles.css">
  <!-- Sweet Alert -->
  <script src="<?= url_base(); ?>/funciones/sweetalert2.all.min.js"></script>



  <title>Document</title>
</head>

<body>
  <div id="preloader">
    <div id="status">
      <div class="spinner"></div>
    </div>
  </div>
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Header (Page header) -->




  <!-- /.content-wrapper -->

</body>

</html>

<?php piepagina($datos_vista); ?>