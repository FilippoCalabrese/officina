<?php

function showDatabaseUsers($link) {
  $result = mysqli_query($link, "SELECT * FROM USERS");
  $html = "<table border='1'>
      <tr>
      <th>USERNAME</th>
      <th>NOME</th>
      <th>COGNOME</th>
      <th>ULTIMO ACCESSO</th>
      <th>LIVELLO UTENTE</th>
      <th>ID</th>
      </tr>";

  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td>".$row['USERNAME']."</td><td>".$row['FIRSTNAME']."</td><td>".$row['LASTNAME']."</td><td>".$row['ACCESS']."</td><td>".$row['LEVEL_ID']."</td><td>".$row['ID']."</td></tr>";
  }
  $html = $html . "</table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;
}



function showDatabaseWorks($link) {
  $result = mysqli_query($link, "SELECT * FROM JOBS");
  $html = "<table border='1'>
      <tr>
      <th>DESCRIZIONE</th>
      <th>NOTE</th>
      <th>DATA DI CREAZIONE</th>
      <th>ULTIMO AGGIORNAMENTO</th>
      <th>DATA DI APERTURA</th>
      <th>DATA DI CHIUSURA</th>
      <th>TEMPO STIMATO</th>
      <th>DATA DI CONSEGNA</th>
      <th>ID</th>
      </tr>";

  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td>".$row['DESCRIPTION']."</td><td>".$row['NOTE']."</td><td>".$row['CREATED_AT']."</td><td>".$row['UPDATED_AT']."</td><td>".$row['OPENED_AT']."</td><td>".$row['CLOSED_AT']."</td><td>".$row['ESTIMATED_TIME']."</td><td>";
      $html = $html . $row['DELIVERY'] . "</td><td>".$row['ID']."</td></tr>";
  }

  $html = $html . "</table>";

  mysqli_free_result($result);
  mysqli_close($con);

  return $html;

}
 ?>
