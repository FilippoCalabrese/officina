<?php
include ('connection.php');

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
	<p>UTENTI PRESENTI NEL SISTEMA</p>
<?php

$result = mysqli_query($link, "SELECT * FROM USERS");

echo "<table border='1'>
    <tr>
    <th>USERNAME</th>
    <th>NOME</th>
    <th>COGNOME</th>
    <th>ULTIMO ACCESSO</th>
    <th>LIVELLO UTENTE</th>
    <th>ID</th>
    </tr>";

while ($row = mysqli_fetch_array($result)) {
    
    echo "<tr>";
    
    echo "<td>" . $row['USERNAME'] . "</td>";
    
    echo "<td>" . $row['FIRSTNAME'] . "</td>";
    
    echo "<td>" . $row['LASTNAME'] . "</td>";
    
    echo "<td>" . $row['ACCESS'] . "</td>";
    
    echo "<td>" . $row['LEVEL_ID'] . "</td>";
    
    echo "<td>" . $row['ID'] . "</td>";
    
    echo "</tr>";
}
echo "</table>";

mysqli_free_result($result);

mysqli_close($con);

?>

<br>
	<form method="post">
		<p>Cancella utente. Attenzione: non verrà chiesta conferma!</p>
		<input type="text" name="deleteUsername" placeholder="Username"> <input
			type="submit" name="deleteUser" value="Rimuovi Utente!">

	</form>

	<br>

	<form method="post">
		<p>Inserisci un nuovo lavoro nel database</p>
		<input type="text" name="description"
			placeholder="Descrizione del lavoro"> <input type="text" name="note"
			placeholder="Note Per Il Lavoro"> <input type="text"
			name="estimated_time"> <input type="date" name="delivery"> <input
			type="submit" name="addJob" value="Aggiungi Utente!">

	</form>

	<br>
	<p>LAVORI PRESENTI NEL SISTEMA</p>
<?php

$result = mysqli_query($link, "SELECT * FROM JOBS");

echo "<table border='1'>
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
    
    echo "<tr>";
    
    echo "<td>" . $row['DESCRIPTION'] . "</td>";
    
    echo "<td>" . $row['NOTE'] . "</td>";
    
    echo "<td>" . $row['CREATED_AT'] . "</td>";
    
    echo "<td>" . $row['UPDATED_AT'] . "</td>";
    
    echo "<td>" . $row['OPENED_AT'] . "</td>";
    
    echo "<td>" . $row['CLOSED_AT'] . "</td>";
    
    echo "<td>" . $row['ESTIMATED_TIME'] . "</td>";
    
    echo "<td>" . $row['DELIVERY'] . "</td>";
    
    echo "<td>" . $row['ID'] . "</td>";
    
    echo "</tr>";
}
echo "</table>";

mysqli_free_result($result);

mysqli_close($con);

?>




<body>


</body>
</html>