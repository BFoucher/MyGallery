<?php
require_once('functions/global.php');
require_once('functions/form.php');
require_once('functions/rooting.php');
require_once('upload.php');
require_once('nbPage.php');


if (isUser()){
  $user = sessionGet('user');
}


?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Super Gallery !</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="static/boostrap.min.css" />
    <link rel="stylesheet" href="static/style.css" />
  </head>
  <body>
  <?php include('navbar.php');?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 text-center">
        <?= errorList();?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-lg-6 col-lg-offset-3 text-center well">
        <?= uploadForm();?>
      </div>
    </div>
    <div class="row">


      <?= $content;?>

    </div>
    <div class="row">
      <div class="well footer text-center">
        <p class="text-muted text-center">MyGallery, est un petit script php pour gérer l'envoie et l'affichage de photos.</p>
        <p class="text-muted text-center">Réalisé en php procédural, utilisation des sessions, cookies.</p>
        <p class="text-muted text-center">Développé dans le cadre d'un tp durant ma formation à l'IMIE.</p>
        <p class="text-muted text-center"><a href="https://bfoucher.fr">Baptiste Foucher</a>.</p>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
  </html>
