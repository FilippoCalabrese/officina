<?php
include 'connection.php';
include 'queryFunctions.php';
include 'utilityFunctions.php';
session_start();
if(isset($_GET['jobId'])){

  $jobRow = fetchSelectedJobData($link);
  $description = $jobRow['DESCRIPTION'];
  $created_at = $jobRow['CREATED_AT'];
  $delivery = $jobRow['DELIVERY'];
  $worked_hours = $jobRow['WORKED_HOURS'];
  $targa = $jobRow['TARGA'];
  $telaio = $jobRow['TELAIO'];

  $logRow = fetchJobActivityData($link, $jobRow['ID']);

    $logRow = fetchJobActivityData($link, $jobRow['ID']);
} else {
    header('Location: index.php');
}

checkCookies();
verifyPermission(10);

if (array_key_exists("updateRequest", $_POST)) {
    updateRequest($link, $jobRow['ID']);
}

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
      <div class="row">
        <div class="col-md-12">
          <br>
          <button class="btn btn-success" data-toggle="collapse" data-target="#edit">Modifica Informazioni</button>



          <form class="collapse" method="POST" id="edit">
            <div class="form-group">
              <label for="exampleInputEmail1">Descrizione</label>
              <input type="text" class="form-control" name="descriptionUpdate" value="<?php echo $description; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Targa</label>
              <input type="text" class="form-control" name="targaUpdate" value="<?php echo $targa; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Telaio</label>
              <input type="text" class="form-control" name="telaioUpdate" value="<?php echo $telaio; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Date di inizio</label>
              <input type="datetime-local" class="form-control" name="creationDate" value="<?php echo $created_at; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Data di fine</label>
              <input type="datetime-local" class="form-control" name="consegnaDate" value="<?php echo $delivery; ?>">
            </div>
            <button type="submit" name="updateRequest" class="btn btn-primary">Aggiorna Informazioni</button>
          </form>
        </div>
        <hr>
        <div class="col-md-12">
          <h1>SCHEDA DEL LAVORO: <?php echo $description ?></h1>
          <br>
          <p>DESCRIZIONE: <?php echo $description; ?></p>
          <p>TARGA: <?php echo $targa; ?></p>
          <p>TELAIO: <?php echo $telaio; ?></p>
          <p>DATA DI INIZIO: <?php echo $created_at; ?></p>
          <p>DATA DI FINE: <?php echo $delivery; ?></p>

          <?php echo showWorkSessions($link); ?>
        </div>
      </div>
    </div>

  </body>
</html>
