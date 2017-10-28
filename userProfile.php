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
  <title>Profilo Utente</title>
</head>
  <body>
    <div class="container">
      <section style="margin-top: 50px;">
        <h1 style="text-transform: uppercase">PROFILO DELL'UTENTE: <?php echo $username; ?></h1>
        <br>
        <p><strong>Nome Utente:</strong> <?php echo $username; ?></p>
        <p><strong>Attività attuale:</strong> <?php echo $isWorking; ?></p>
      </section>


      <section>
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
      </section>
    </body>
    </div>
</html>
