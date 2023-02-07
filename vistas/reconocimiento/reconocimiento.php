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
    <link href="<?= url_base(); ?>/Horizontal/public/assets/css/icons.css" rel="stylesheet" type="text/css" />

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

            </div>

        </div>
    </section>



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
                border-bottom: none;

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

</body>

</html>