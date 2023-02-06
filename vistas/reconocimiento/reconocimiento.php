<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $datos_vista['titulo_ventana']; ?></title>
    <link rel="shortcut icon" href="<?= url_base(); ?>/archivos/imagenes/logo-u.png">
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

        .cardi {
            background-color: #fff;
            border-radius: 5px;
            padding: 25px;
        }

        .flexi {
            /* width: 80%; */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= url_base(); ?>/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <link href="<?= url_base(); ?>/archivos/css/estilos_generales.css" rel="stylesheet" />
    <!-- Estilos dropzone -->
    <link href="<?= url_base(); ?>/archivos/css/estilos_dropzone.css" rel="stylesheet" />
    <link href="<?= url_base(); ?>/Horizontal/public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= url_base(); ?>/Horizontal/public/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= url_base(); ?>/Horizontal/public/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body style="padding-bottom: 0px;" class="hold-transition sidebar-mini layout-fixed <?= COLOR_TEMA ?>">

    <!-- Site wrapper -->
    <div>

        <!-- Navigation Bar-->
        <header>
            <div class="topbar-main" style="background-color: #004A98;height: 120px;display:flex;">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo">
                        <a href="index.php" class="logo">
                            <img src="<?= url_base(); ?>/archivos/imagenes/Logo_Universidad.png" alt="" height="120">
                        </a>
                    </div>
                </div> <!-- end container -->
            </div>

        </header>
        <!-- End Navigation Bar-->

        <div style="width: 100%; height: 500px; ">

            <!-- <div class="row card" style="width: 800px; margin: 0px auto; margin-top:60px;"> -->
            <div class="row"">
            <div class=" col-md-6">
                <img src="<?= url_base() ?>/archivos/imagenes/dooble.svg" width="600px" style="margin-left:40px; margin-top:20px; width: 100%;" alt="">

            </div>
            <div class="col-md-6 flexi">
                <div class="cardi">
                    <div class="row">
                        <div class="col-md-12">
                            <b>Nombre del evento :</b>
                            <p style="margin-right: 10px;" id="nombreEvento" name="nombreEvento">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, excepturi? Alias expedita nihil dolore in suscipit rerum quod ipsa provident!</p>
                        </div>
                    </div>

                    <div class=" row">
                        <div class="col-md-6">
                            <b>Fecha del evento:</b>
                            <p style=" margin-right: 10px;" id="fechaEvento" name="fechaEvento">12,13 de Febrero de 2023</p>
                        </div>
                        <div class=" col-md-6">
                            <b>Fecha de expedición:</b>
                            <p style=" margin-right: 10px;" id="fechaExpedicion" name="fechaExpedicion">13/02/2023</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <b>Nombre Completo:</b>
                            <p style=" margin-right: 10px;" id="nombreCompleto" name="nombreCompleto">Pedro Pedoro Zanchez Maruchines</p>
                        </div>
                        <div class=" col-md-6">
                            <b>Tipo de Participación:</b>
                            <p style=" margin-right: 10px;" id="tipoParticipacion" name="tipoParticipacion">CONFERENCIA</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-6">
                            <b>Lugar del Evento:</b>
                            <p style=" margin-right: 10px;" id="lugarEvento" name="lugarEvento">San Salvador</p>
                        </div>
                        <div class="col-md-6">
                            <b>Codigo:</b>
                            <p style=" margin-right: 10px; color:#004A98;" id="codigo" name="codigo">asdftyui456hnmjfe67</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>
    <!-- Content Wrapper. Contains page content -->
    <!-- /.content-wrapper -->

    <?php piepagina($datos_vista); ?>