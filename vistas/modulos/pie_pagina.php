<footer class="main-footer footer_space">
  <strong>Copyright &copy; <?= date("Y"); ?> <a class="text-<?= COLOR_SIDEBAR_ACTIVO ?>" href="" target="_blank">Facultad de Contaduria y Administración</a>.</strong> Todos los derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  const url_base = "<?= url_base(); ?>";
  const imagenes_alertas = "<?= imagenes_alertas(); ?>";
  const imagenes_botones = "<?= imagenes_botones(); ?>";
  const token = "<?= token_sesion(); ?>";
  const sidebar_activo = "<?= COLOR_SIDEBAR_ACTIVO ?>";
</script>
<script src="<?= url_base(); ?>/funciones/js_generales.js"></script>
<?php if ($datos_vista['nombre_pagina'] != "error") { ?>
  <script src="<?= url_base(); ?>/funciones/<?= $datos_vista['archivo_funciones']; ?>"></script>
<?php } ?>
<!-- jQuery -->
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/modernizr.min.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/waves.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/jquery.slimscroll.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/jquery.nicescroll.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/jquery.scrollTo.min.js"></script>
<!-- overlayScrollbars -->
<!-- <script src="<?= url_base(); ?>/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- Select2 -->
<script src="<?= url_base(); ?>/template/plugins/select2/js/select2.full.min.js"></script>
<!-- Sweetalert -->
<script src="<?= url_base(); ?>/template/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Datatables -->
<script src="<?= url_base(); ?>/template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= url_base(); ?>/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= url_base(); ?>/template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= url_base(); ?>/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.dataTables.min.css">
<!-- jquery-validation -->
<script src="<?= url_base(); ?>/template/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= url_base(); ?>/template/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- custom file input -->
<script src="<?= url_base(); ?>/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?= url_base(); ?>/template/plugins/jquery-ui-1.13.2.custom/jquery-ui.min.js"></script>
<!-- drpzone -->
<script src="<?= url_base(); ?>/template/plugins/dropzone/min/dropzone.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= url_base(); ?>/template/plugins/adminlte/js/adminlte.min.js"></script>
<script src="<?= url_base(); ?>/Horizontal/public/assets/js/app.js"></script>

<!-- AdminLTE for demo purposes <script src="template/plugins/adminlte/js/demo.js"></script>-->

<script src="<?= url_base(); ?>/funciones/qrcode.min.js"></script>
<script src="<?= url_base(); ?>/funciones/jquery-ui.multidatespicker.js"></script>


<link rel="stylesheet" type="text/css" href="<?= url_base(); ?>/funciones/jquery-ui.css">

</body>

</html>