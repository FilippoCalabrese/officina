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



<html>
  <head>
  </head>
  <body>

    <h1> Pannello di AMMINISTRAZIONE</h1>

    <!--- FORM PER AGGIUNGERE UTENTI -->
  	<form method="post">
  		<p>Inserisci un nuovo utente nel database</p>
  		<input type="text" name="username" placeholder="Username"> <input
  			type="text" name="password" placeholder="Password"> <input
  			type="text" name="firstname" placeholder="Nome"> <input type="text"
  			name="lastname" placeholder="Cognome"> <input type="date"
  			name="access" placeholder="Data"> <input type="text" name="level_id"
  			placeholder="Level ID"> <input type="submit" name="addUser"
  			value="Aggiungi Utente!">
  	</form>
  	<br>



    <!--- UTENTI PRESENTI NEL SISTEMA -->
  	<p>UTENTI PRESENTI NEL SISTEMA</p>
      <?php
        echo showDatabaseUsers($link);
      ?>
    <br>



    <!--- FORM PER CANCELLARE UTENTI -->
  	<form method="post">
  		<p>Cancella utente. Attenzione: non verrà chiesta conferma!</p>
  		<input type="text" name="deleteUsername" placeholder="Username"> <input
  			type="submit" name="deleteUser" value="Rimuovi Utente!">
  	</form>
  	<br>



    <!--- FORM PER AGGIUNGERE UN LAVORO -->
  	<form method="post">
  		<p>Inserisci un nuovo lavoro nel database</p>
  		<input type="text" name="description"
  			placeholder="Descrizione del lavoro"> <input type="text" name="note"
  			placeholder="Note Per Il Lavoro"> <input type="text"
  			name="estimated_time" placeholder="Tempo Stimato"> <input type="date" name="delivery"> <input
  			type="submit" name="addJob" value="Aggiungi Lavoro!">
  	</form>
  	<br>



    <!--- MOSTRA I LAVORI PRESENTI NEL SISTEMA -->
  	<p>LAVORI PRESENTI NEL SISTEMA</p>
      <?php echo showDatabaseWorks($link); ?>



      <!--- FORM PER CANCELLARE JOB -->
    	<form method="post">
    		<p>Cancella JOB. Attenzione: non verrà chiesta conferma!</p>
    		<input type="text" name="deleteJob" placeholder="ID"> <input
    			type="submit" name="deleteJobSubmit" value="Rimuovi JOB!">
    	</form>
    	<br>



  </body>
</html>
