<?php
include('connection.php');
include('queryFunctions.php');
include('utilityFunctions.php');
if(isset($_GET['jobId'])){

  $jobRow = fetchSelectedJobData($link);
  $description = $jobRow['DESCRIPTION'];
  $note = $jobRow['NOTE'];
  $created_at = $jobRow['CREATED_AT'];
  $estimated_time = $jobRow['ESTIMATED_TIME'];
  $delivery = $jobRow['DELIVERY'];
  $worked_hours = $jobRow['WORKED_HOURS'];

  $logRow = fetchJobActivityData($link, $jobRow['ID']);

} else {
  header("Location: index.php");
}
session_start();

checkCookies();
verifyPermission(10);

if (array_key_exists("submitHours", $_POST)) {
    countsHours($link);
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
</head>
  <body>
    <div class="container">
      <h1>SCHEDA DEL LAVORO: <?php echo $description ?></h1>
      <br>
      <p>DESCRIZIONE: <?php echo $description; ?></p>
      <p>NOTE: <?php echo $note; ?></p>
      <p>DATA DI CREAZIONE: <?php echo $created_at; ?></p>
      <p>TEMPO STIMATO: <?php echo $estimated_time; ?></p>
      <p>DATA DI CONSEGNA: <?php echo $delivery; ?></p>
      <p>TOTALE ORE LAVORATE: <?php echo $worked_hours; ?></p>
      <p>CONTATORE PARZIALE ORE:</p>
      <table>
        <?php //TODO sparare le singole righe delle ore lavorate ?>
      </table>
    </div>

  </body>
</html>