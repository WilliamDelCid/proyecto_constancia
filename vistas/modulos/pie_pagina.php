<style>
  .foooter {
    width: 100%;
    /* height: 280px; */
    background-color: #004A98;
    padding: 25px 50px 30px 50px;
    border-top: 8px solid #00B2E3;
    position: relative;
    left: 0;
    bottom: 0;
    margin-top: 50px;
    /* text-align: center; */
  }

  .fa {
    color: #fff;
    /* width: 60px; */
  }

  .info {
    /* max-width: 900px;
    margin-inline: auto;
    grid-template-columns: 750px 1fr;
     */
    display: grid;
    gap: 20px;
    color: #fff;
  }

  .redes_sociales {
    max-width: 900px;
    margin-inline: auto;
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
  }

  .anchor {
    color: #fff;
    font-weight: 800;
    border-bottom: 1px solid #fff;

    /* desktop */
    /* font-size: 20px; */
  }





  @media screen and (min-width:900px) {
    .info {
      max-width: 900px;
      margin-inline: auto;
      grid-template-columns: 750px 1fr;
    }

    .foooter {
      height: 280px;

    }

    .anchor {
      transition: all 0.3s;
      border-bottom: unset;

    }

    .anchor:hover {
      color: #fff;
      border-bottom: 2px solid #fff;
    }
  }
</style>

<footer class="foooter">

  <div class="info">

    <div>

      <div class="redes_sociales">
        <a href="https://www.facebook.com/LaUASLP/" target="_blank">
          <span class="fa fa-facebook-square fa-lg"></span>
        </a>
        <a href="https://twitter.com/LaUASLP" target="_blank">
          <span class="fa fa-twitter-square fa-lg"></span>
        </a>
        <a href="https://www.youtube.com/LaUASLP" target="_blank">
          <span class="fa fa-youtube-play fa-lg"></span>
        </a>

        <a href="https://www.instagram.com/lauaslp" target="_blank">
          <span class="fa fa-instagram fa-lg"></span>
        </a>

        <a href="https://www.linkedin.com/school/somosuaslp/" target="_blank">
          <span class="fa fa-linkedin-square fa-lg"></span>
        </a>

      </div>


      <div id="identidad">
        <span><b>UASLP</b></span><br>
        <span>Universidad Autónoma de San Luis Potosí</span><br>
        <span>Álvaro Obregón 64, Centro. CP 78000</span><br>
        <span>San Luis Potosí, SLP</span><br>
        <span>444 826 23 00</span><br>
        <span>©2023 Todos los derechos reservados</span><br>
      </div>

    </div>



    <div class="container_links">
      <div><a class="anchor" href="https://www.uaslp.mx//">Universidad</a></div>
      <div><a class="anchor" href="https://www.uaslp.mx/ProgramasAcademicos">Oferta Educativa</a></div>
      <div><a class="anchor" href="https://www.uaslp.mx/InvestigacionyPosgrado#gsc.tab=0">Investigación</a></div>
      <div><a class="anchor" href="https://www.uaslp.mx/DifusionCultural">Cultura</a></div>
      <div><a class="anchor" href="https://www.uaslp.mx/	Paginas/General/2595">Vinculación</a></div>
      <div><a class="anchor" href="https://www.uaslp.mx/Paginas/General/2596">Internacional</a></div>
      <div><a class="anchor" href="https://transparencia.uaslp.mx/Paginas/TRANSPARENCIA-Y-ACCESO-A-LA-INFORMACION-PUBLICA/3157#gsc.tab=0">Transparencia</a></div>
    </div>

  </div>


</footer>


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