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
<div class="container" style="background-color: white;">
    <section id="userSection">
      <h2 style="margin-bottom: 15px;">GESTIONE UTENTI</h2>
      <div class="row">
        <div class="col-md-4">
          <!--- FORM PER AGGIUNGERE UTENTI -->
        	<form method="post">
        		<h3>inserisci un nuovo utente</h3>
        		<input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="password" placeholder="Password"><br>
            <input type="text" name="firstname" placeholder="Nome"><br>
            <input type="text" name="lastname" placeholder="Cognome"><br> 
            <input type="text" name="level_id" placeholder="Level ID"><br>
            <input class="btn btn-success" type="submit" name="addUser" value="Aggiungi Utente!"><br>
        	</form>
        	<br>
        </div>



        <div class="col-md-8">
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


    <section id="jobSection" style="margin-top: 60px;">
      <h2 style="margin-bottom: 15px;">GESTIONE LAVORI</h2>
      <div class="row">
        <div class="col-md-12">
          <!--- MOSTRA I LAVORI PRESENTI NEL SISTEMA -->
        	<h3>lavori presenti nel sistema</h3>
            <?php echo showDatabaseWorks($link); ?>
            <!--- FORM PER CANCELLARE JOB -->
          	<form method="post">
          		<h3 style="margin-top: 30px;">cancella lavoro. Attenzione: non verrà chiesta conferma</h3>
          		<input type="text" name="deleteJob" placeholder="ID">
              <input class="btn btn-success" type="submit" name="deleteJobSubmit" value="Rimuovi JOB!">
          	</form>
            <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!--- FORM PER AGGIUNGERE UN LAVORO -->
        	<form method="post">
        		<h3>inserisci un nuovo lavoro</h3>
        		<input type="text" name="description" placeholder="Descrizione del lavoro"><br>
            <input type="text" name="note" placeholder="Note Per Il Lavoro"><br>
            <input type="text" name="estimated_time" placeholder="Tempo Stimato"><br>
            <label for="delivery">Data di consegna: </label>
            <input type="date" name="delivery"><br>
            <input class="btn btn-success" type="submit" name="addJob" value="Aggiungi Lavoro!"><br>
        	</form>
        </div>
      </div>
    </section>



  </body>
</div>
</html>
