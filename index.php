<?php
include 'constants.php';
include ('queryFunctions.php');
include ('utilityFunctions.php');
include ('connection.php');

session_start();
$error = "";
if (array_key_exists("logout", $_GET)) {
    writeDatabaseLog($link, "Logout dal sistema");
    session_unset();
    setcookie("id", "", time() - 60 * 60);
  	setcookie("level_id", "", time() - 60 * 60);
    $_COOKIE["id"] = "";
  	$_COOKIE["level_id"] = "";
} else if ((array_key_exists("id", $_SESSION) and $_SESSION['id']) or (array_key_exists("id", $_COOKIE) and $_COOKIE['id'])) {
    redirectToCorrectPage();
}
if (array_key_exists("submit", $_POST)) {
    if (! $_POST['username']) {
        $error .= "Devi inserire il tuo nome utente<br>";
    }
    if (! $_POST['password']) {
        $error .= "A password is required<br>";
    }
    if ($error != "") {
        $error = "<p>There were error(s) in your form:</p>" . $error;
    } else {
        $error = performLogin($link);
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

  <div class="container">
    <div id="error"><?php echo $error; ?></div>

    <h1>bt auto - login al sistema gestionale</h1>


        <form method="post">
      <div class="form-group">
        <label for="username">Email address</label>
        <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter email">
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
      <input type="submit" name="submit" value="Log In!" class="btn btn-success">
    </form>



  </div>

</body>
</html>
