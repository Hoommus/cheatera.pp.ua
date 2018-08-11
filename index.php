<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon"  href="/icon_uf.png" >
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-122178531-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-122178531-1');
</script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <!-- Custom styles for this template -->
    <link href="/style.css" rel="stylesheet">
    <title><?php if ($_GET['name']) echo $_GET['name'].' :: ' ?><?php if ($_GET['page']) echo $_GET['page'].' :: ' ?><?php if ($_GET['course']) echo $_GET['course'].' :: ' ?>cheatera.pp.ua</title>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
  </head>
  <body>
<body>

<?php @include 'duty/db.php'; ?>
<?php @include 'html/header.php' ?>

    <!-- Begin page content -->
    <main role="main" class="container">
      <?php
  session_start();
  $_SESSION['api_rd'] = "https://api.intra.42.fr/oauth/authorize?client_id=cd246e491edfbd25e7ed90b4cd8194468e71fe174c50d89734ba80f9090b72ed&redirect_uri=https%3A%2F%2Fcheatera.pp.ua%2Faccess.php&response_type=code";

 if (!$_GET['course'] && !$_GET['page'] && !$_GET['name']) {
   @include 'html/home.php';
 }
 else if ($_SESSION['cheat'] == session_id())
  {
      if ($_GET['course'] == '404') {
        @include 'html/404.php';
      }
      if ($_GET['course'] == 'bastards' || $_GET['course'] == 'students') {
        if ($_GET['page'] && $_GET['page'] == 'projects') {
          if ($_GET['name']) {
            @include 'html/project.php';
          }
          else {
            @include 'html/projects.php';
          }
        }
        else if ($_GET['page'] && $_GET['page'] == 'cheat') {
          @include 'html/cheat.php';
        }
        else if ($_GET['page']) {
          @include 'html/xlogin.php';
        }
        else {
          @include 'html/users.php';
        }
      }
      else if ($_GET['course'] != '404' && $_GET['course']) {
        header("Location: https://cheatera.pp.ua/404/");
      }
}
else {
  header("Location: " . $_SESSION['api_rd']);
}
      ?>
    </main>

<?php @include 'html/footer.php' ?>
  </body>
</html>