<?php
include 'constants.php';
include 'queryFunctions.php';
include 'utilityFunctions.php';
include 'connection.php';

session_start();
$error = '';

if (array_key_exists('registerEnter', $_POST)) {
    registerEntrance($link);
}

if (array_key_exists('registerExit', $_POST)) {
    registerExit($link);
}

if (array_key_exists('entrance', $_GET)) {
    echo '<div class="alert alert-warning" role="alert">
          INGRESSO REGISTRATO. BUON LAVORO!
        </div>';
}

<<<<<<< HEAD
if(array_key_exists("errorRegistration", $_GET)) {
  echo '<div class="alert alert-danger" role="alert">
=======
if (array_key_exists('errorRegistration', $_GET) || array_key_exists('errorRegistration', $_GET)) {
    echo '<div class="alert alert-danger" role="alert">
>>>>>>> d78c408f51015aba7c2742531da0b5c893713e0a
          ATTENZIONE! NON HAI INSERITO IL TUO NOME UTENTE. RIPROVA
        </div>';
}

if (array_key_exists('exit', $_GET)) {
    echo '<div class="alert alert-primary" role="alert">
          USCITA REGISTRATA. BUONA SERATA!
        </div>';
}

if (array_key_exists('closeWork', $_POST)) {
    updateWork($link);
    closeWork($link);
}

if (array_key_exists('logout', $_GET)) {
    writeDatabaseLog($link, 'Logout dal sistema');
    session_unset();
    setcookie('id', '', time() - 60 * 60);
    setcookie('level_id', '', time() - 60 * 60);
    $_COOKIE['id'] = '';
    $_COOKIE['level_id'] = '';
} elseif ((array_key_exists('id', $_SESSION) and $_SESSION['id']) or (array_key_exists('id', $_COOKIE) and $_COOKIE['id'])) {
    redirectToCorrectPage();
}
if (array_key_exists('submit', $_POST)) {
    if (!$_POST['username']) {
        $error .= 'Devi inserire il tuo nome utente<br>';
    }
    if (!$_POST['password']) {
        $error .= 'A password is required<br>';
    }
    if ($error != '') {
        $error = '<p>There were error(s) in your form:</p>'.$error;
    } else {
        $error = performLogin($link);
    }
}
if (array_key_exists('submitOfficina', $_POST)) {
    if (!$_POST['username']) {
        $error .= 'Devi inserire il tuo nome utente<br>';
    }

    if ($error != '') {
        $error = '<p>There were error(s) in your form:</p>'.$error;
    } else {
        $error = performLoginOfficina($link);
    }
}
?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>

  <div class="container container-home">
    <div id="error"><?php echo $error; ?></div>
<br>
<br>
    <div class="row">
      <div class="col-md-6">
          <img src="img/logo.png" alt="" style="height: 120px;">
      </div>
      <div class="col-md-6">
        <div id="clock" style="font-size: 80px; font-weight: bold; color: black;"> </div>
          </div>
      </div>

      <?php
      if (getUserIP() != '151.8.33.101') {
          ?>
      <form method="post">
      <div class="form-group">
        <label for="username">Nome Utente</label>
        <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="nome utente">
        <small id="emailHelp" class="form-text text-muted">Inserisci il tuo nome utente.</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
      </div>
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="stayLoggedIn">
          Rimani Loggato
        </label>
      </div>
      <input type="submit" name="submit" value="Entra" class="btn btn-success">
    </form>
    <?php
      } else {
          ?>
    <h2>LAVORAZIONE</h2>
    <form method="post">
      <div class="form-group">
        <input type="text" name="username" class="form-control" value="" placeholder="Nome utente">
      </div>
      <input type="submit" name="submitOfficina" value="Entra" class="btn btn-success">
    </form>
  <?php
      }?>
    <hr>


    <div class="row">
      <div class="col-md-4">
        <h1>INGRESSO</h1>
        <form class="" method="post">
          <div class="form-group">
            <label for="username2">Nome Utente</label>
            <input type="text" name="username" class="form-control" id="username2" aria-describedby="usernameHelp" placeholder="nome utente">
            <small id="emailHelp" class="form-text text-muted">Inserisci il tuo nome utente.</small>
          </div>
          <input type="submit" name="registerEnter" value="REGISTRA INGRESSO" class="btn btn-primary">

        </form>
        <hr>
      </div>
      <div class="col-md-4">
        <h1>USCITA</h1>
        <form class="" method="post">
          <div class="form-group">
            <label for="username">Nome Utente</label>
            <input type="text" name="username" class="form-control" id="username3" aria-describedby="usernameHelp" placeholder="nome utente">
            <small id="emailHelp" class="form-text text-muted">Inserisci il tuo nome utente.</small>
          </div>
          <input type="submit" name="registerExit" value="REGISTRA USCITA" class="btn btn-warning">

        </form>
        <hr>
      </div>
      <div class="col-md-4">
        <h3>UTENTI AL LAVORO:</h3>
        <?php echo showOpenSession($link); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php
    date_default_timezone_set('UTC');
    ?>
    <script>


    var d = new Date(<?php echo time() * 1000 ?>);
    function digitalClock() {
      d.setTime(d.getTime() + 1000);
      var hrs = d.getHours();
      var mins = d.getMinutes();
      var secs = d.getSeconds();
      mins = (mins < 10 ? "0" : "") + mins;
      secs = (secs < 10 ? "0" : "") + secs;
      var ctime = hrs + ":" + mins + ":" + secs;
      document.getElementById("clock").firstChild.nodeValue = ctime;
    }
    window.onload = function() {
      digitalClock();
      setInterval('digitalClock()', 1000);
    }
    </script>


    </div>


  </div>

</div>

</body>
</html>
