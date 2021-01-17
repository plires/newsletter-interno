<?php 
  include('php/getNewsletter.php');
?>

<!doctype html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicons -->
  <?php include('includes/favicon.inc.php'); ?>

  <!-- Normalize -->
  <link rel="stylesheet" href="node_modules/normalize.css/normalize.css">

  <!-- Animate -->
  <link rel="stylesheet" href="node_modules/wowjs/css/libs/animate.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/newsletter-front.css">

  <title>Vistage - Newsletter Interno - <?= $newsletter['name'] ?></title>

</head>
<body>

  <header class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1><img class="img-fluid wow bounceInRight" src="img/logo-vistage.png" alt="logo vistage"></h1>
        </div>
      </div>
    </div>
    <h2 class="wow bounceInLeft">NEWSLETTER INTERNO <br><span><?= $newsletter['name_month'] .' '. $newsletter['year']  ?></span></h2>
  </header>

  <section class="container">

    <!-- Tabla -->
    <?php if ( !empty($rows_table) ): ?>
      
      <div class="tabla">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Indicadores Operativos</h2>
          </div>
        </div>

        <div class="row wow fadeInLeft">
          <div class="col-lg-8">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col text-center">EC</th>
                    <th scope="col text-center">RP</th>
                    <th scope="col text-center">CS</th>
                    <th scope="col text-center">TOTAL</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($rows_table as $row): ?>
                    <tr>
                      <td class="text-center"><?= $row['name'] ?></td>
                      <td class="text-center"><?= $row['ec'] ?></td>
                      <td class="text-center"><?= $row['rp'] ?><</td>
                      <td class="text-center"><?= $row['cs'] ?><</td>
                      <td class="text-center"><?= $row['total'] ?><</td>
                    </tr>
                  <?php endforeach ?>
                  
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-lg-4">

            <div class="jumbotron jumbotron-fluid wow fadeInRight">
              <p class="lead"><?= $newsletter['comment_table_a'] ?></p>
            </div>

            <div data-wow-delay="0.2s" class="jumbotron jumbotron-fluid wow fadeInRight">
              <p class="lead"><?= $newsletter['comment_table_b'] ?></p>
            </div>

            <div data-wow-delay="0.4s" class="jumbotron jumbotron-fluid wow fadeInRight">
              <p class="lead"><?= $newsletter['comment_table_c'] ?></p>
            </div>
            
            <p class="text-center observaciones wow fadeInUp"><?= $newsletter['observations_table'] ?></p>

          </div>
        </div>
      </div>
      
    <?php endif ?>
    <!-- Tabla End -->

    <!-- Calendario -->
    <?php if ( !empty($calendars) ): ?>

      <div class="calendario">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Calendario de Actividades</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">

          <?php foreach ($calendars_final as $key => $calendar): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">

              <div class="card text-white mb-3" style="max-width: 18rem; margin: auto;">
                <div class="card-header text-center"><i class="fas fa-calendar-alt"></i><p><?= ucfirst($calendar['name_day']) .' '. $calendar['number_day'] ?></p></div>
                <div class="card-body">
                  <p class="card-text"><?= $calendar['description'] ?></p>
                </div>
                <div class="card-footer text-center">
                  <p><i class="far fa-clock"></i> <?= $calendar['time_init'] .' - '. $calendar['time_end'] ?></p>
                </div>
              </div>
            </div>
            
          <?php endforeach ?>
         
        </div>
      </div>
      
    <?php endif ?>
    <!-- Calendario End -->

    <!-- Gerencia General -->
    <?php if ( !empty($newsletter['gerencia_general']) ): ?>

      <div class="gerencia_general">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Gerencia General</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">
          <div class="col-md-12">
            <p><?= $newsletter['gerencia_general'] ?></p>
          </div>
        </div>
      </div>

    <?php endif ?>
    <!-- Gerencia General End -->

    <!-- Gerencia y Talento y Negocios -->
    <?php if ( !empty($newsletter['gerencia_talento']) ): ?>

      <div class="gerencia_talento">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Gerencia y Talento y Negocios</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">
          <div class="col-md-12">
            <p><?= $newsletter['gerencia_talento'] ?></p>
          </div>
        </div>
      </div>

    <?php endif ?>
    <!-- Gerencia y Talento y Negocios End -->

    <!-- Administración y Finanzas -->
    <?php if ( !empty($newsletter['administracion_finanzas']) ): ?>

      <div class="gerencia_finanzas">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Administración y Finanzas</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">
          <div class="col-md-12">
            <p><?= $newsletter['administracion_finanzas'] ?></p>
          </div>
        </div>
      </div>

    <?php endif ?>
    <!-- Administración y Finanzas End -->

    <!-- Marketing -->
    <?php if ( !empty($newsletter['marketing']) ): ?>

      <div class="marketing">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Marketing</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">
          <div class="col-md-12">
            <p><?= $newsletter['marketing'] ?></p>
          </div>
        </div>
      </div>

    <?php endif ?>
    <!-- Marketing End -->

    <!-- Operaciones -->
    <?php if ( !empty($newsletter['operaciones']) ): ?>

      <div class="operaciones">
        <div class="row">
          <div class="col-md-12">
            <h2 class="wow fadeInLeft">Operaciones</h2>
          </div>
        </div>

        <div class="row wow fadeInUp">
          <div class="col-md-12">
            <p><?= $newsletter['operaciones'] ?></p>
          </div>
        </div>
      </div>

    <?php endif ?>
    <!-- Operaciones End -->

  </section>

  <div class="footer-basic container-fluid">
    <footer class="container">

      <div class="row">
        <div class="col-md-12">
          <div class="social">
            <a target="_blank" class="transition" href="https://www.linkedin.com/company/vistage-s-a-/"><i class="fab fa-linkedin"></i></a>
            <a target="_blank" class="transition" href="https://www.instagram.com/vistageargentina/"><i class="fab fa-instagram-square"></i></a>
            <a target="_blank" class="transition" href="https://www.facebook.com/vistage.argentina"><i class="fab fa-facebook-square"></i></a>
            <a target="_blank" class="transition" href="https://twitter.com/vistageARG"><i class="fab fa-twitter-square"></i></a>
            <a target="_blank" class="transition" href="https://www.youtube.com/user/VistageArgentina"><i class="fab fa-youtube"></i></a>
          </div>
          <div class="text-center">
            <img class="img-fluid" src="img/logo-footer.png" alt="logo vistage footer">
          </div>
        </div>
      </div>

      <div class="row libre">
        <div class="col-md-12">
          <hr>
          <a target="_blank" href="https://www.librecomunicacion.net/" class="libre transition">by libre</a>
        </div>  
      </div>

    </footer>
  </div>

  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/wowjs/dist/wow.min.js"></script>

  <script>
    new WOW().init();
  </script>

</body>
</html>