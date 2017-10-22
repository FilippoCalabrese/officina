<?php
include ('connection.php');
include ('queryFunctions.php');
session_start();



//controlla se sono presenti cookie di navigazione ed in caso li usa per visualizzare la pagina
if (array_key_exists("id", $_COOKIE)) {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['level_id'] = $_COOKIE['level_id'];
}



//verifica se l'utente si è loggato con credenziali appropriate a visualizzare la pagina
if (array_key_exists("id", $_SESSION) and $_SESSION['level_id'] == 100) {
    echo "<p>Loggato come Amministratore! <a href='index.php?logout=1'>Log out</a></p>";
} else {
    header("Location: index.php");
}



// rimuove l'utente se si è compilato il form
if (array_key_exists("deleteUser", $_POST)) {
    $userToDelete = $_POST['deleteUsername'];
    $sql = "DELETE FROM USERS WHERE USERNAME = '" . $userToDelete . "'";
    $result = $link->query($sql);
    mysqli_free_result($result);
}



// aggiunge un lavoro se è stato compilato il form
if (array_key_exists("addJob", $_POST)) {
    $description = $_POST['description'];
    $note = $_POST['note'];
    $estimated_time = $_POST['estimated_time'];
    $delivery = $_POST['delivery'];
    $sql = "INSERT INTO JOBS (DESCRIPTION, NOTE, CREATED_AT, UPDATED_AT, ESTIMATED_TIME, DELIVERY, OPENED_AT, CLOSED_AT) VALUES ('$description ', '$note', CURRENT_DATE(), CURRENT_DATE(), '$estimated_time', '$delivery', CURRENT_DATE(), CURRENT_DATE())";
    $result = $link->query($sql);
    echo $result;
    mysqli_free_result($result);
}



// aggiunge utente se è stato compilato il form
if (array_key_exists("addUser", $_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $access = $_POST['access'];
    $level_id = $_POST['level_id'];
    $sql = "INSERT INTO USERS (USERNAME, PASSWORD, FIRSTNAME, LASTNAME, ACCESS, LEVEL_ID) VALUES ('$username ', '$password', '$firstName', '$lastName', '$access', '$level_id')";
    $result = $link->query($sql);
    echo $result;
    mysqli_free_result($result);
}
?>



<html>
  <head>
  </head>
  <body>



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
      <?php
        echo showDatabaseWorks($link);
      ?>



  </body>
</html>
