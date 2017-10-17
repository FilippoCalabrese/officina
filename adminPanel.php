<?php

include('connection.php');

session_start();

if (array_key_exists("id", $_COOKIE)) {
    
    $_SESSION['id'] = $_COOKIE['id'];
    
    $_SESSION['level_id'] = $_COOKIE['level_id'];
}

if (array_key_exists("id", $_SESSION) and $_SESSION['level_id'] == 100) {
    
    echo "<p>Loggato come Amministratore! <a href='index.php?logout=1'>Log out</a></p>";
    
} else {
    
    header("Location: index.php");
}


//aggiunge utente se è stato compilato il form

if (array_key_exists("addUser", $_POST)) {
    
    $username = $_POST['username'];
    
    $password = $_POST['password'];
    
    $firstName = $_POST['firstname'];
    
    $lastName = $_POST['lastname'];
    
    $access = $_POST['access'];
    
    $level_id = $_POST['level_id'];
    
    $sql = "INSERT INTO USERS (USERNAME, PASSWORD, FIRSTNAME, LASTNAME, ACCESS, LEVEL_ID) VALUES ('. $username . ', '. $password .', '.$firstname .', '.$lastname .', '.$access .', '.$level_id .')";
    
    $result = $link->query($sql);
    
    echo $result;
    
}


?>

<html>
<head>
</head>
<body>
	<form method="post">
	<p>Inserisci un nuovo utente nel database</p>
	<input type="text" name="username" placeholder="Username"> 
	<input type="text" name="password" placeholder="Password"> 
	<input type="text" name="firstname" placeholder="Nome"> 
	<input type="text" name="lastname" placeholder="Cognome"> 
	<input type="date" name="access" placeholder="Data"> 
	<input type="text" name="level_id" placeholder="Level ID"> 
	 <input type="submit" name="addUser"
		value="Aggiungi Utente!">

</form>
</body>
</html>