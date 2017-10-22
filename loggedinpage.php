<?php
include ('connection.php');
include ('queryFunctions.php');
include ('utilityFunctions.php');
session_start();

checkCookies();
verifyPermission(10);
?>



<html>
  <head>
  </head>
  <body>

    <h1> Pannello UTENTE</h1>

    <!--- MOSTRA I LAVORI PRESENTI NEL SISTEMA -->
  	<p>LAVORI PRESENTI NEL SISTEMA</p>

    <?php echo showDatabaseWorks($link); ?>



  </body>
</html>
