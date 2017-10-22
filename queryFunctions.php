<?php
/*
* MOSTRA GLI UTENTI PRESENTI NEL DATABASE
*/
function showDatabaseUsers($link) {
  $result = mysqli_query($link, "SELECT * FROM USERS");
  $html = "<table border='1'>
      <tr>
      <th>USERNAME</th>
      <th>NOME</th>
      <th>COGNOME</th>
      <th>ULTIMO ACCESSO</th>
      <th>LIVELLO UTENTE</th>
      <th>ID</th>
      </tr>";

  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td>".$row['USERNAME']."</td><td>".$row['FIRSTNAME']."</td><td>".$row['LASTNAME']."</td><td>".$row['ACCESS']."</td><td>".$row['LEVEL_ID']."</td><td>".$row['ID']."</td></tr>";
  }
  $html = $html . "</table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;
}


/*
* MOSTRA I LAVORI PRESENTI NEL DATABASE
*/
function showDatabaseWorks($link) {
  $result = mysqli_query($link, "SELECT * FROM JOBS");
  $html = "<table border='1'>
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
      $html = $html . "<tr><td>".$row['DESCRIPTION']."</td><td>".$row['NOTE']."</td><td>".$row['CREATED_AT']."</td><td>".$row['UPDATED_AT']."</td><td>".$row['OPENED_AT']."</td><td>".$row['CLOSED_AT']."</td><td>".$row['ESTIMATED_TIME']."</td><td>";
      $html = $html . $row['DELIVERY'] . "</td><td>".$row['ID']."</td></tr>";
  }
  $html = $html . "</table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;

}



/*
* CANCELLA L'UTENTE DAL DATABASE
*/
function deleteUserFromDb($link) {
  $userToDelete = $_POST['deleteUsername'];
  $sql = "DELETE FROM USERS WHERE USERNAME = '" . $userToDelete . "'";
  $result = $link->query($sql);
  mysqli_free_result($result);
  writeDatabaseLog($link, "cancellato utente ".$userToDelete);
}



/*
* CANCELLA L'UTENTE DAL DATABASE
*/
function deleteJobFromDb($link) {
  $jobToDelete = $_POST['deleteJob'];
  $sql = "DELETE FROM JOBS WHERE ID = " . $jobToDelete;
  $result = $link->query($sql);
  mysqli_free_result($result);
  writeDatabaseLog($link, "Cancellato JOB con id = ".$jobToDelete);
}



/*
* INSERISCE UN NUOVO LAVORO NEL DATABASE
*/
function insertNewWorkInDb($link){
  $description = $_POST['description'];
  $note = $_POST['note'];
  $estimated_time = $_POST['estimated_time'];
  $delivery = $_POST['delivery'];
  $sql = "INSERT INTO JOBS (DESCRIPTION, NOTE, CREATED_AT, UPDATED_AT, ESTIMATED_TIME, DELIVERY, OPENED_AT, CLOSED_AT) VALUES ('$description ', '$note', CURRENT_DATE(), CURRENT_DATE(), '$estimated_time', '$delivery', CURRENT_DATE(), CURRENT_DATE())";
  $result = $link->query($sql);
  echo $result;
  mysqli_free_result($result);
  writeDatabaseLog($link, "aggiunto nuovo lavoro");
}



/*
* INSERISCE UN NUOVO UTENTE NEL DATABASE
*/
function addUserInDb($link) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $firstName = $_POST['firstname'];
  $lastName = $_POST['lastname'];
  $access = $_POST['access'];
  $level_id = $_POST['level_id'];
  $sql = "INSERT INTO USERS (USERNAME, PASSWORD, FIRSTNAME, LASTNAME, ACCESS, LEVEL_ID) VALUES ('$username ', '$password', '$firstName', '$lastName', '$access', '$level_id')";
  $result = $link->query($sql);
  echo $result;
  mysqli_free_result($result);
  writeDatabaseLog($link, "aggiunto nuovo utente");
}



/*
* SCRIVE UN MESSAGGIO NELLA TABELLA DI LOG DEL DATABASE
*/
function writeDatabaseLog($link, $message) {
  $sql = "INSERT INTO ACTIVITIES (LABEL, TIMESTRAP, USERID, IP_ADDRESS) VALUES ('".$message."', NOW(),".$_SESSION['id'].", '".getUserIP()."')";
  $result = $link->query($sql);
  mysqli_free_result($result);
}



//legge l'indirizzo ip da cui l'utente è connesso
function getUserIP() {
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}



/*
* LOGGA L'UTENTE
*/
function performLogin($link) {
  $query = "SELECT * FROM USERS WHERE USERNAME = '" . mysqli_real_escape_string($link, $_POST['username']) . "'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  $error = "";
  mysqli_free_result($result);
  if (isset($row)) {
      // $hashedPassword = md5(md5($row['id']) . $_POST['password']); deve essere ripristinato una volta implementata l'aggiunta utenti!
      $hashedPassword = md5($_POST['password']);
      if ($hashedPassword == $row['PASSWORD']) {
          $_SESSION['id'] = $row['ID'];
          $_SESSION['level_id'] = $row['LEVEL_ID'];
          $_SESSION['is_working'] = $row['ISWORKING'];

          if ($_POST['stayLoggedIn'] == '1') {
              setcookie("id", $row['ID'], time() + 60 * 60 * 24 * 365);
              setcookie("level_id", $row['LEVEL_ID'], time() + 60 * 60 * 24 * 365);
          }
          writeDatabaseLog($link, $row['USERNAME'].": Login nel sistema");
          if(!(intval($_SESSION['is_working'])==0)){
            redirectToWorkPage();
          } else {
            redirectToCorrectPage();
          }
      } else {
          $error = "Login fallito. Riprova";
      }
  } else {
      $error = "Login fallito. Riprova.";
  }
  return $error;
}



/*
* REDIREZIONA L'UTENTE ALLA PAGINA DEL LAVORO IN CORSO
*/
function redirectToWorkPage(){
  session_start();
  if(!(intval($_SESSION['is_working'])==0)){
    header('Location: work.php');
  }
}



/*
* INTERROGA IL DATABASE E VERIFICA SE L'UTENTE LOGGATO STA O MENO LAVORANDO A QUALCHE PROGETTO
*/
function verifyUserIsWorking($link) {
  if(intval($_SESSION['is_working']) == 0){
    header('Location: index.php');
  }
  $query = "SELECT * FROM JOBS WHERE ID=".intval($_SESSION['is_working']);
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
  showCurrentWork($row);
}



/*
* IMPAGINA LA RIGA IN ENTRATA IN UNA TABELLA HTML PER MOSTRARE IL LAVORO IN CORSO
*/
function showCurrentWork($row) {
  echo "<strong>DESCRIZIONE: </strong>".$row['DESCRIPTION']."<br><strong>NOTE: </strong>".$row['NOTE']."<br><strong>TEMPO STIMATO: </strong>".$row['ESTIMATED_TIME']."<br><strong>CONSEGNA: </strong>".$row['DELIVERY']."<br><strong>CONTATORE PARZIALE ORE: </strong>".$row['WORKED_HOURS']."<br>";
}



/*
* CONTEGGIA ULTERIORI ORE NEL JOB
*/
function countsHours($link) {
  $query = "SELECT * FROM JOBS WHERE ID=".intval($_SESSION['is_working']);
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  $hours = $_POST['hours'] + $row['WORKED_HOURS'];
  mysqli_free_result($result);
  $query = "UPDATE JOBS SET WORKED_HOURS=" .$hours . " WHERE ID = " .$_SESSION['is_working'];
  $result = mysqli_query($link, $query);
  mysqli_free_result($result);
}
 ?>
