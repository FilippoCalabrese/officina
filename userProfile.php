<?php
include('connection.php');
include('utilityFunctions.php');
include('queryFunctions.php');
if(isset($_GET['userProfileId'])){

  $userRow = fetchSelectedUserData($link);
  $username = $userRow['USERNAME'];
  $firstName = $userRow['FIRSTNAME'];
  $lastName = $userRow['LASTNAME'];
  $isWorking = $userRow['ISWORKING'];
  $logRow = fetchDatabaseLogData($link, $userRow['ID']);

} else {
  header("Location: index.php");
}


?>

<html>
  <head>
      <title>Visualizzazione Profilo Utente</title>
  </head>
  <body>
    <h1>PROFILO DELL'UTENTE: <?php echo $username; ?></h1>
    <br>
    <p>Nome Utente: <?php echo $username; ?></p>
    <p>Attività attuale: <?php echo $isWorking; ?></p>
    <h2>Log relativi all'utente:</h2>
    <table>
      <tr>
        <th>Attività</th>
        <th>Data ed Ora</th>
        <th>Indirizzo IP</th>
      </tr>
      <?php

        while( $row = mysqli_fetch_array($logRow) ) {
          echo printLogTable($row);
        }

      ?>
    </table>
  </body>
</html>
