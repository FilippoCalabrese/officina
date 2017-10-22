<?php
include('connection.php');
include('queryFunctions.php');
include('utilityFunctions.php');

session_start();

checkCookies();
verifyPermission(10);

if (array_key_exists("submitHours", $_POST)) {
    countsHours($link);
}
?>

<html>

  <head>
    <title>Il tuo lavoro attuale</title>
  </head>

  <body>
    <?php verifyUserIsWorking($link); ?>
    <br>

    <form method="post">
    	<input type="text" name="hours" placeholder="Numero di ore da conteggiare">
      <input type="submit" name="submitHours"
    		value="Conteggia Ore!">
    </form>
  </body>

</html>
