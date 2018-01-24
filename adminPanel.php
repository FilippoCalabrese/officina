<?php
include ('connection.php');
include ('queryFunctions.php');
include ('utilityFunctions.php');
session_start();



checkCookies();
verifyPermission(100);


// rimuove l'utente se si è compilato il form
if (array_key_exists("deleteUser", $_POST)) {
    deleteUserFromDb($link);
}



// rimuove l'utente se si è compilato il form
if (array_key_exists("deleteJobSubmit", $_POST)) {
    deleteJobFromDb($link);
}



// aggiunge un lavoro se è stato compilato il form
if (array_key_exists("addJob", $_POST)) {
    insertNewWorkInDb($link);
}



// aggiunge utente se è stato compilato il form
if (array_key_exists("addUser", $_POST)) {
    addUserInDb($link);
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/r-2.2.1/sc-1.4.3/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/r-2.2.1/sc-1.4.3/datatables.min.js"></script>


  <script type="text/javascript">
    $(document).ready( function () {
    $('table').dataTable({
        responsive: true,
        "scrollX": true,
        dom: "Bfrtip",
        buttons: [
            'excel',
            'print',
            'pdf'
        ]
    });
    } );
  </script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
</head>

<body>
<div class="container" style="background-color: white;">
  <section>
    <div class="row">
      <div class="col-md-12">
        <br>
        <ul class="nav nav-pills" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="utenti-tab" data-toggle="tab" href="#utenti" role="tab" aria-controls="utenti" aria-selected="true">Utenti</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="lavori-tab" data-toggle="tab" href="#lavori" role="tab" aria-controls="lavori" aria-selected="false">Lavori</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="ingressi-tab" data-toggle="tab" href="#ingressi" role="tab" aria-controls="ingressi" aria-selected="false">Ingressi e uscite</a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show" id="ingressi" role="tabpanel" aria-labelledby="ingressi-tab">


            <section id="userSection">
              <div class="row">
                <div class="col-md-4">
                  <h1 style="margin-bottom: 15px;">INGRESSI ED USCITE</h1>
                </div>
              </div>

              <?php echo showEntranceAndExit($link); ?>
            </section>


          </div>

          <div class="tab-pane fade show active" id="utenti" role="tabpanel" aria-labelledby="utenti-tab">


            <section id="userSection">
              <div class="row">
                <div class="col-md-4">
                  <h1 style="margin-bottom: 15px;">GESTIONE UTENTI</h1>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_utenti" style="margin-top: 10px;">+ Nuovo Utente</button>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <!-- Modal -->
                  <div id="modal_utenti" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                          <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4>Aggiungi Utente</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                          <form method="post">
                            <div class="form-group">
                              <label for="description">Username</label>
                              <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="username">
                            </div>
                            <div class="form-group">
                              <label for="password">Password</label>
                              <input type="text" name="password" class="form-control" id="password" placeholder="password">
                            </div>
                            <div class="form-group">
                              <label for="firstname">Nome</label>
                              <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Nome">
                            </div>
                            <div class="form-group">
                              <label for="lastname">Cognome</label>
                              <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Cognome">
                            </div>
                            <div class="form-group">
                              <label for="level_id">Livello User (10 utente, 100 amministratore)</label>
                              <select class="form-control" id="level_id" name="level_id">
                                <option>10</option>
                                <option>100</option>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="addUser">Submit</button>
                          </form>
                          <br>
                        </div>

                      </div>
                    </div>
                  </div>


                  <!--- UTENTI PRESENTI NEL SISTEMA -->
                	<h3>utenti presenti nel sistema</h3>
                    <?php
                      echo showDatabaseUsers($link);
                    ?>
                  <br>
                  <hr>


                  <!--- FORM PER CANCELLARE UTENTI -->
                	<form method="post">
                		<h3>cancella utente. Attenzione: Non verrà chiesta conferma</h3>
                		<input type="text" name="deleteUsername" placeholder="Username">
                    <input type="submit" name="deleteUser" class="btn btn-success" value="Rimuovi Utente!">
                	</form>
                	<br>
                </div>
              </div> <!--- row -->
              <hr>
            </section>


          </div>
          <div class="tab-pane fade" id="lavori" role="tabpanel" aria-labelledby="lavori-tab">
            <section id="jobSection">
              <div class="row">
                <div class="col-md-4">
                  <h1 style="margin-bottom: 15px;">GESTIONE LAVORI</h1>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_lavori" style="margin-top: 10px;">+ Nuovo Lavoro</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <!-- Modal -->
                  <div id="modal_lavori" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                          <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4>Aggiungi un lavoro</h4>
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
                              <input type="text" name="targa" class="form-control" id="Targa" placeholder="Targa">
                            </div>
                            <div class="form-group">
                              <label for="telaio">ID (separati da spazio) a cui assegnare il lavoro</label>
                              <input type="text" name="assegna" class="form-control" id="assegna" placeholder="IDs">
                            </div>
                            <div class="form-group">
                              <label for="delivery">Data di consegna</label>
                              <input type="date" name="delivery" class="form-control" id="delivery" placeholder="">
                            </div>
                            <div class="form-group">
                              <input type="hidden" name="forall" value="0">
                            </div>
                            <button type="submit" class="btn btn-primary" name="addJob">Submit</button>
                          </form>

                          <br>
                        </div>

                      </div>
                    </div>
                  </div>


                  <!--- MOSTRA I LAVORI PRESENTI NEL SISTEMA -->
                	<h3>lavori attivi nel sistema</h3>
                    <div>
                    <?php echo showDatabaseWorks($link); ?>
                    </div>
                    <!--- FORM PER CANCELLARE JOB -->
                  	<form method="post">
                  		<h3 style="margin-top: 30px;">cancella lavoro. Attenzione: non verrà chiesta conferma</h3>
                  		<input type="text" name="deleteJob" placeholder="ID">
                      <input class="btn btn-success" type="submit" name="deleteJobSubmit" value="Rimuovi JOB!">
                  	</form>
                    <hr>
                </div>
              </div>

                <h2 style="margin-bottom: 15px;">LAVORI COMPLETATI DI RECENTE</h2>
              <div class="row">
                <div class="col-md-12">
                  <!--- MOSTRA I LAVORI PRESENTI NEL SISTEMA -->
                    <?php echo showCompletedWorks($link); ?>
                    <hr>
                </div>
              </div>
            </section>


          </div>
          <!--- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --->
        </div>
      </div>
    </div>
  </section>

  </body>
</div>
</html>
