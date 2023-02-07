<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= url_base(); ?>/archivos/imagenes/logo-u.png">

    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

        header {
            background-color: #004A98;
            height: 120px;
        }

        #imagen_logo {
            width: 100%;
            object-fit: contain;
        }

        .section__container {
            max-width: 1200px;
            height: auto;
            /* background-color: red; */
            margin-inline: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .card {
            width: 95%;
            /* min-height: 600px; */
            padding: 20px;
            /* max-height: 600px; */
            background: #07182E;
            position: relative;
            display: flex;
            place-content: center;
            place-items: center;
            overflow: hidden;
            border-radius: 20px;
            margin-inline: auto;
        }

        .card div {
            z-index: 1;
            color: black;
            margin-inline: auto;
            font-size: 14px;
        }

        .card::before {
            content: '';
            position: absolute;
            width: 100px;
            background-image: linear-gradient(180deg, rgb(0, 74, 152), rgb(0, 74, 152));
            height: 130%;
            animation: rotBGimg 6s linear infinite;
            transition: all 0.9s linear;
        }

        @keyframes rotBGimg {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        h2 {
            /* font-size: px; */
            text-align: center;
            margin-top: 20px;
            padding-inline: 20px;
        }

        .card::after {
            content: '';
            position: absolute;
            background: #fff;
            ;
            inset: 5px;
            border-radius: 15px;
        }

        #card__container {
            width: 290px;
            /* height: 600px; */
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            color: black;
            text-align: center;
        }

        #imagen_persona {
            /* z-index: 1; */
            width: 280px;
            display: block;
            /* max-width: 500px; */
            margin-inline: auto;
            margin-top: 20px;
        }

        .texts__info {
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: center;
            line-height: 1.5;

        }

        .row {
            width: 100%;

            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        /* .card:hover:before {
            background-image: linear-gradient(180deg, rgb(81, 255, 0), purple);
            animation: rotBGimg 3.5s linear infinite;
        }
 */


        @media only screen and (min-width: 425px) {
            #imagen_logo {
                display: flex;
                width: 420px;
                margin: 0 auto;
            }
        }

        @media only screen and (min-width: 768px) {
            #imagen_logo {
                display: flex;
                width: 420px;
                margin: unset;
            }

            #card__container {
                width: 100%;
                /* height: 500px; */
                display: grid;
                grid-template-columns: 400px 1fr;
                align-content: center;
            }

            .texts__info {
                text-align: left;

            }

            .divImagen {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #imagen_persona {
                width: 350px;
            }
        }

        @media only screen and (min-width: 992px) {
            #card__container {
                width: 100%;
                /* height: 500px; */
                display: grid;
                grid-template-columns: 500px 1fr;
                align-content: center;
            }

            #imagen_persona {
                width: 450px;
            }

            h2 {
                font-size: 32px;

            }
        }
    </style>
</head>

<body>
    <section>

        <header>
            <img id="imagen_logo" src="<?= url_base(); ?>/archivos/imagenes/Logo_Universidad.png" alt="" height="120">
        </header>

    </section>
    <h2>El reconococimiento es valido</h2>
    <section class="section__container">
        <div class="card">
            <div id="card__container">

                <div class="divImagen">
                    <iframe src="<?= url_base(); ?>/web/viewer.html?file=http://localhost/proyecto_constancia/constancias/reconocimiento?id=<?= $datos_vista['datos']['datos'][0]['token_unico'] ?>" type="application/pdf" width="100%" height="300px"> </iframe>
                    <!-- <iframe src="<?= url_base(); ?>/constancias/reconocimiento?id=68aca5120b8bf7362beaac89" width=" auto" height="auto"> </iframe> -->
                    <!-- <img id="imagen_persona" src="<?= url_base() ?>/archivos/imagenes/dooble.svg" alt="Imagen Referencia"> -->
                    <!-- <a href=>AAAA</a> -->
                </div>

                <div class="texts__info">
                    <div class="row">
                        <b>Nombre del evento:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['nombre_evento'] ?></p>
                    </div>
                    <div class="row">
                        <b>Nombre del participante:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['nombre_formulario'] . ' ' . $datos_vista['datos']['datos'][0]['apellido_formulario'] ?></p>
                    </div>
                    <div class="row">
                        <b>Fecha del Evento:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['fecha_evento'] ?></p>
                    </div>
                    <div class="row">
                        <b>Fecha de expedición:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['fecha_expedicion'] ?></p>
                    </div>
                    <div class="row">
                        <b>Lugar del Evento:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['lugar_evento'] ?></p>
                    </div>
                    <div class="row">
                        <b>Token único:</b>
                        <p><?= $datos_vista['datos']['datos'][0]['token_unico'] ?></p>
                    </div>
                </div>
                <!-- <div class="row">
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
                    <div class="col-md-6">
                        <b>Nombre Completo:</b>
                        <p style=" margin-right: 10px;" id="nombreCompleto" name="nombreCompleto">Pedro Pedoro Zanchez Maruchines</p>
                    </div>
                    <div class=" col-md-6">
                        <b>Tipo de Participación:</b>
                        <p style=" margin-right: 10px;" id="tipoParticipacion" name="tipoParticipacion">CONFERENCIA</p>
                    </div>
                </div> -->
            </div>

        </div>
    </section>

</body>

</html>