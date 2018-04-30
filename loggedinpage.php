<?php
include ('connection.php');
include ('queryFunctions.php');
include ('utilityFunctions.php');
session_start();

checkCookies();
verifyPermission(10);

// aggiunge un lavoro se è stato compilato il form
if (array_key_exists("addJob", $_POST)) {
    insertNewWorkInDbFromUser($link);
}


if(array_key_exists("taken", $_POST)) {
  $_SESSION['is_working'] = intval($_POST['taken']);
  updateMyWork($link);

  header("Location: work.php");
}

?>



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

            <h1> <?php echo $_SESSION['username']; ?></h1>

            <?php echo showMyWorks($link); ?>
      </div>
        <hr>
        <br>
    <section id="jobSection" style="margin-top: 60px; padding-bottom: 40px;">
      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_utenti" style="margin-top: 10px;">+ Aggiungi un lavoro</button>

          <div id="modal_utenti" class="modal fade" role="dialog">
            <div class="modal-dialog">
                  <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4>Aggiungi Un Lavoro</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <form method="post">
                    <div class="form-group">
                      <label for="description">Descrizione</label>
                      <input type="text" name="description" class="form-control" id="description" aria-describedby="emailHelp" placeholder="Descrizione">
                    </div>
                    <div class="form-group">
                      <label for="targa">Targa</label>
                      <input type="text" name="targa" class="form-control" id="Targa" placeholder="Targa" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="forall" value="1">
                    </div>
                    <button type="submit" class="btn btn-success" name="addJob">Aggiungi</button>
                  </form>
                  <br>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    </div>
  </body>
</html>
