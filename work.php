<?php
include('connection.php');
include('queryFunctions.php');
include('utilityFunctions.php');

session_start();
checkCookies();
verifyPermission(10);

if (array_key_exists("closeWork", $_POST)) {
    updateWork($link);
    closeWork($link);
    //TODO: inserire conteggio ore
    header("Location: index.php");
}

if(array_key_exists("suspendWork", $_POST)){
  countWorkSession($link);
}

if(array_key_exists("restartWork", $_POST)){
  unlockWork($link);
}


?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
  <script type="text/javascript">
    $(document).ready( function () {
    $('table').dataTable();
    } );
  </script>
  <title>Il Tuo Lavoro Attuale</title>
</head>

  <body>
    <div class="container" style="text-align: center;">
        <?php verifyUserIsWorking($link); ?>
        <br>

        <form method="post">
          <input type="submit" class="btn btn-warning" name="closeWork" value="Chiudi" style="margin-bottom: 30px;">
        </form>
        <form method="post">
          <?php echo showCorrectButton($link); ?>
        </form>
    </div>
  </body>

</html>
