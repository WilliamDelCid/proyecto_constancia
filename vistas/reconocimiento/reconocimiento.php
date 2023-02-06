<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            width: 300px;
            height: auto;
            /* background-color: red; */
            margin-inline: auto;
            margin-top: 20px;
        }

        .card {
            width: 300px;
            min-height: 600px;
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
            background-image: linear-gradient(180deg, rgb(0, 183, 255), rgb(0, 183, 255));
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
            height: 600px;
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            color: black;
            text-align: center;
        }

        #imagen_persona {
            z-index: 1;
            width: 280px;
            /* max-width: 500px; */
            margin-inline: auto;
            margin-top: 20px;
        }

        .card:hover:before {
            background-image: linear-gradient(180deg, rgb(81, 255, 0), purple);
            animation: rotBGimg 3.5s linear infinite;
        }



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
        }
    </style>
</head>

<body>
    <section>

        <header>
            <img id="imagen_logo" src="<?= url_base(); ?>/archivos/imagenes/Logo_Universidad.png" alt="" height="120">
        </header>

    </section>
    <section class="section__container">
        <div class="card">
            <div id="card__container">
                <img id="imagen_persona" src="<?= url_base() ?>/archivos/imagenes/dooble.svg" alt="Imagen Referencia">
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
            </div>

        </div>
    </section>
</body>

</html>