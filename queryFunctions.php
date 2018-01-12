<?php
/*
* MOSTRA GLI UTENTI PRESENTI NEL DATABASE
*/
function showDatabaseUsers($link) {
  $result = mysqli_query($link, "SELECT * FROM USERS");
  $html = "<table id='usertable' width='100%' class='table table-stripped'>
      <thead>
      <tr>
      <th>USERNAME</th>
      <th>NOME</th>
      <th>COGNOME</th>
      <th>ULTIMO ACCESSO</th>
      <th>ULTIMO LOGOUT</th>
      <th>LIVELLO UTENTE</th>
      <th>ID</th>
      </tr></thead>";

  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td><a target='_blank' href='userProfile.php?userProfileId=".$row['ID']."'>".$row['USERNAME']."</a></td><td>".$row['FIRSTNAME']."</td><td>".$row['LASTNAME']."</td><td>".$row['ACCESS']."</td><td>".$row['LOGOUT']."</td><td>".$row['LEVEL_ID']."</td><td>".$row['ID']."</td></tr>";
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
  $result = mysqli_query($link, "SELECT * FROM JOBS WHERE CLOSED_AT IS NULL");
  $html = "<table id='workTable' width='100%' class='table table-stripped'>

      <thead>
      <tr><th>DESCRIZIONE</th>
      <th>NOTE</th>
      <th>DATA DI APERTURA</th>
      <th>TEMPO STIMATO</th>
      <th>DATA DI CONSEGNA</th>
      <th>TARGA</th>
      <th>TELAIO</th>
      <th>ID</th>
      </tr>
      </thead><tbody>";
  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td><a href='job.php?jobId=".$row['ID']."' target='_blank'>".$row['DESCRIPTION']."</a></td><td>".$row['NOTE']."</td><td>".$row['OPENED_AT']."</td><td>".$row['ESTIMATED_TIME']."</td><td>" . $row['DELIVERY'] ."</td><td>" . $row['TARGA'] ."</td><td>" . $row['TELAIO'] . "</td><td>".$row['ID']."</td></tr>";
  }
  $html = $html . "</tbody></table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;

}

//mostra i lavori completati
function showCompletedWorks($link) {
  $result = mysqli_query($link, "SELECT * FROM JOBS WHERE CLOSED_AT IS NOT NULL");
  $html = "<table class='table table-stripped'>
      <thead>
      <tr>
      <th>DESCRIZIONE</th>
      <th>NOTE</th>
      <th>DATA DI CREAZIONE</th>
      <th>DATA DI APERTURA</th>
      <th>DATA DI CHIUSURA</th>
      <th>TEMPO STIMATO</th>
      <th>DATA DI CONSEGNA</th>
      <th>TARGA</th>
      <th>TELAIO</th>
      <th>ID</th>
      </tr>
      </thead>";
  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td><a href='job.php?jobId=".$row['ID']."' target='_blank'>".$row['DESCRIPTION']."</a></td><td>".$row['NOTE']."</td><td>".$row['CREATED_AT']."</td><td>".$row['OPENED_AT']."</td><td>".$row['CLOSED_AT'];
      $html = $html ."</td><td>".$row['ESTIMATED_TIME']."</td><td>" . $row['DELIVERY'] ."</td><td>" . $row['TARGA'] ."</td><td>" . $row['TELAIO'] . "</td><td>".$row['ID']."</td></tr>";
  }
  $html = $html . "</table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;

}


/*
* MOSTRA I LAVORI ASSEGNATI
*/
function showMyWorks($link) {
  $sql = "SELECT * FROM JOBS WHERE CLOSED_AT IS NULL AND ID IN (SELECT JOB_ID FROM ASSIGNED_JOBS WHERE USER_ID LIKE '%". $_SESSION['id'] ."%' ) OR FORALL=1 AND CLOSED_AT IS NULL";
  $result = mysqli_query($link, $sql);
  $html = "<table class='table table-stripped'>
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
      $html = $html . "<tr><td><a href='job.php?jobId=".$row['ID']."' target='_blank'>".$row['DESCRIPTION']."</a></td><td>".$row['NOTE']."</td><td>".$row['CREATED_AT']."</td><td>".$row['UPDATED_AT']."</td><td>".$row['OPENED_AT']."</td><td>";
      $html = $html .$row['CLOSED_AT']."</td><td>".$row['ESTIMATED_TIME']."</td><td>".$row['DELIVERY'] . "</td><td><form method='post'>
        <button type='submit' class='btn btn-sm btn-success' name='taken' value=".$row['ID'].">Inizia</button></form></td></tr>";
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
* COMINCIA L'ATTIVITÀ PER L'UTENTE CORRENTE
*/
function updateMyWork($link) {
  $sql = "UPDATE USERS SET ISWORKING = ".$_POST['taken']." WHERE id =".$_SESSION['id'];
  $result = $link->query($sql);

  $sql = "UPDATE JOBS SET OPENED_AT = DATE_ADD(NOW(), INTERVAL 8 HOUR) WHERE ID =".$_POST['taken'];
  $result = $link->query($sql);
  writeDatabaseLog($link, "Ha cominciato il lavoro con id =".$_POST['taken']);
  header('Location: index.php');
  unlockWork($link);
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
  $targa = $_POST['targa'];
  $telaio = $_POST['telaio'];
  $forall = intval($_POST['forall']);
  $sql = "INSERT INTO JOBS (DESCRIPTION, NOTE, CREATED_AT, UPDATED_AT, ESTIMATED_TIME, DELIVERY, TARGA, TELAIO, FORALL) VALUES ('$description ', '$note', CURRENT_DATE(), CURRENT_DATE(), '$estimated_time', '$delivery', '$targa','$telaio', $forall)";
  $result = $link->query($sql);
  //echo $result;
    if(!($forall == 1)){
        assignJobToUser($link);
    }
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
  $level_id = $_POST['level_id'];
  $sql = "INSERT INTO USERS (USERNAME, PASSWORD, FIRSTNAME, LASTNAME, LEVEL_ID) VALUES ('$username ', '$password', '$firstName', '$lastName', '$level_id')";
  $result = $link->query($sql);
  echo $result;
  mysqli_free_result($result);
  writeDatabaseLog($link, "aggiunto nuovo utente");
}



/*
* SCRIVE UN MESSAGGIO NELLA TABELLA DI LOG DEL DATABASE
*/
function writeDatabaseLog($link, $message) {
  $sql = "INSERT INTO ACTIVITIES (LABEL, TIMESTRAP, USERID, IP_ADDRESS) VALUES ('".$message."', DATE_ADD(NOW(), INTERVAL 8 HOUR),".$_SESSION['id'].", '".getUserIP()."')";
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
          $_SESSION['username'] = $row['USERNAME'];
          $_SESSION['level_id'] = $row['LEVEL_ID'];
          $_SESSION['is_working'] = $row['ISWORKING'];
          updateLastLogin($link);
          if ($_POST['stayLoggedIn'] == '1') {
              setcookie("id", $row['ID'], time() + 60 * 60 * 24 * 365);
              setcookie("level_id", $row['LEVEL_ID'], time() + 60 * 60 * 24 * 365);
          }
          writeDatabaseLog($link, "Login nel sistema");
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
* AGGIORNA DATA ED ORA DELL'ULTIMO LOGIN
*/
function updateLastLogin($link) {
  $query = "UPDATE USERS SET ACCESS = DATE_ADD(NOW(), INTERVAL 8 HOUR) WHERE ID=".$_SESSION['id'];
  $result = mysqli_query($link, $query);
  mysqli_free_result($result);
}



/*
* REDIREZIONA L'UTENTE ALLA PAGINA DEL LAVORO IN CORSO
*/
function redirectToWorkPage(){
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
  echo "<strong>DESCRIZIONE: </strong>".$row['DESCRIPTION']."<br><strong>NOTE: </strong>".$row['NOTE']."<br><strong>TARGA: </strong>".$row['TARGA']."<br><strong>TELAIO: </strong>".$row['TELAIO']."<br><strong>TEMPO STIMATO: </strong>".$row['ESTIMATED_TIME']."<br><strong>CONSEGNA: </strong>".$row['DELIVERY']."<br><strong>DATA DI INIZIO LAVORO: </strong>".$row['OPENED_AT']."<br>";
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
  $query = "INSERT INTO JOBS_TIME(USER_ID, JOB_ACTIVITY_ID, TIME) VALUES (".$_SESSION['id'].", ".$_SESSION['is_working'].", ".  $_POST['hours'].")";
  $result = mysqli_query($link, $query);
  mysqli_free_result($result);
}


/*
* Recupera le informazioni dell'utente dal database e restituisce la row
* contenente le informazioni
*/
function fetchSelectedUserData($link) {
  $query = "SELECT * FROM USERS WHERE ID = '" . $_GET['userProfileId'] . "'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  return $row;
}


/*
* Recupera le informazioni dell'utente dal database e restituisce la row
* contenente le informazioni
*/
function fetchSelectedJobData($link) {
  $query = "SELECT * FROM JOBS WHERE ID = " . $_GET['jobId'];
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  return $row;
}

function fetchJobActivityData($link, $id) {
  $query = "SELECT * FROM JOBS_ACTIVITIES WHERE ID = " . $id;
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  return $row;
}



/*
* Recupera tutti i log presenti nella tabella relativi all'utente desiderato.
* Restituisce la row contenente le informazioni
*/
function fetchDatabaseLogData($link, $id){
  $query = "SELECT * FROM ACTIVITIES WHERE USERID = '".$id."' ORDER BY TIMESTRAP DESC LIMIT 15";
  $result = mysqli_query($link, $query);
  return $result;
}



/*
*CHIUDE IL LAVORO A CUI L'UTENTE STA ATTUALMENTE LAVORANDO
*/
function updateWork($link) {
  $sql = "UPDATE USERS SET ISWORKING = 0 WHERE ID =".$_SESSION['id'];
  $result = $link->query($sql);
}



/*
*CHIUDE IL LAVORO A CUI L'UTENTE STA ATTUALMENTE LAVORANDO
*/
function closeWork($link) {
  $sql = "UPDATE JOBS SET CLOSED_AT = DATE_ADD(NOW(), INTERVAL 8 HOUR) WHERE ID =".$_SESSION['is_working'];
  $result = $link->query($sql);
  writeDatabaseLog($link, "Completato il lavoro attuale");
  countWorkSession($link);
}

/*
*   ASSEGNA IL LAVORO ALL'UTENTE DESIGNATO
*/

function assignJobToUser($link) {
    $utente = $_POST['assegna'];
    $sql = "INSERT INTO ASSIGNED_JOBS (USER_ID, JOB_ID) VALUES ('".$utente."', (SELECT MAX(ID) FROM JOBS))";
    $result = $link->query($sql);
    writeDatabaseLog($link, "Assegnato un Job all'utente");
}

function countWorkSession($link) {
  $sql = "SELECT * FROM JOBS WHERE ID=".intval($_SESSION['is_working']);
  $result = $link->query($sql);
  $row = mysqli_fetch_array($result);
  $jobId = $row['ID'];
  $myName = $_SESSION['username'];
  $sql = "UPDATE `WORK_SESSION` SET `FINISH` = DATE_ADD(NOW(), INTERVAL 8 HOUR) WHERE USERNAME ='".$_SESSION['username']."' AND WORK_ID = ".$jobId." AND FINISH IS NULL";
  $result = $link->query($sql);
  $sql = "UPDATE JOBS SET SUSPENDED = 1 WHERE ID =".$jobId;
  $result = $link->query($sql);
  writeDatabaseLog($link, "Sospeso e conteggiato il lavoro con id = ".$jobId);
}

function unlockWork($link) {
  $sql = "SELECT * FROM JOBS WHERE ID=".intval($_SESSION['is_working']);
  $result = $link->query($sql);
  $row = mysqli_fetch_array($result);
  $jobId = $row['ID'];
  $sql = "UPDATE JOBS SET SUSPENDED = 0 WHERE ID =".$jobId;
  $result = $link->query($sql);
  $sql = "UPDATE JOBS SET UPDATED_AT = DATE_ADD(NOW(), INTERVAL 8 HOUR) WHERE ID =".$jobId;
  $result = $link->query($sql);
    $sql = "INSERT INTO `WORK_SESSION`(`START`,`WORK_ID`, `USERNAME`) VALUES (DATE_ADD(NOW(), INTERVAL 8 HOUR), ".$jobId.", '".$_SESSION['username']."')";
    $result = $link->query($sql);
    echo($sql);
  writeDatabaseLog($link, "Ricominciato il lavoro con id = ".$jobId);
}

function showCorrectButton($link) {
  $sql = "SELECT * FROM JOBS WHERE ID=".intval($_SESSION['is_working']);
  $result = $link->query($sql);
  $row = mysqli_fetch_array($result);
  $isSuspended = $row['SUSPENDED']==1;
  if($isSuspended){
  return '<input type="submit" class="btn btn-success" name="restartWork" value="Ricomincia" style="margin-bottom: 30px;">';
  } else {
    return '<input type="submit" class="btn btn-warning" name="suspendWork" value="Sospendi" style="margin-bottom: 30px;">';
  }
}

function showWorkSessions($link) {
  $sql = "SELECT * FROM WORK_SESSION WHERE WORK_ID =".$_GET['jobId'];
  $result = mysqli_query($link, $sql);
  $html = "<table class='table table-stripped'>
      <tr>
      <th>UTENTE</th>
      <th>ORA DI INIZIO</th>
      <th>ORA DI FINE</th>
      </tr>";
  while ($row = mysqli_fetch_array($result)) {
      $html = $html . "<tr><td>".$row['USERNAME']."</td><td>".$row['START']."</td><td>".$row['FINISH']."</td></tr>";
  }
  $html = $html . "</table>";
  mysqli_free_result($result);
  mysqli_close($con);
  return $html;

}
 ?>
