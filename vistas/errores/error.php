<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= url_base(); ?>/vistas/errores/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "poppins";
    }

    .page_404 {
      padding: 40px 0;
      background: #fff;
      font-family: 'Poppins';
    }

    .page_404 img {
      width: 100%;
    }

    /* .four_zero_four_bg {
      height: 400px;
      background-position: center;
    } */

    h1 {
      font-size: 80px;
    }

    h3 {
      font-size: 80px;
    }

    a {
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      background: #39ac31;
      display: inline-block;
    }

    .content_box_404 {
      margin-top: -50px;
    }

    a:hover {
      text-decoration: none;
      color: #fff;
    }
  </style>
  <title>Document</title>
</head>

<body>
  <section class="page_404">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-10 col-sm-offset-1 text-center">
            <div style="background: url(<?= url_base(); ?>/archivos/imagenes/bg.gif); height: 400px;background-position: center;">
              <h1 class="text-center">404</h1>
            </div>
            <div class="content_box_404">
              <h3 class="h2">¿Estas perdido?</h3>
              <p>La página que buscas no está disponible</p>
              <a href="<?= url_base(); ?>/">Volver al inicio</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>