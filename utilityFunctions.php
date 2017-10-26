<?php



//redireziona l'utente all'appropriata pagina di amministrazione / visualizzazione
function redirectToCorrectPage(){
  if(($_SESSION['level_id']==999) or ($_COOKIE['level_id'] == 999)){
    header("Location: superAdminPanel.php");
  }else if(($_SESSION['level_id']==100) or ($_COOKIE['level_id'] == 100)) {
    header("Location: adminPanel.php");
  } else {
    header("Location: loggedinpage.php");
  }
}



//verifica se l'utente si è loggato con credenziali appropriate a visualizzare la pagina
function verifyPermission($level) {
  if (array_key_exists("id", $_SESSION) and $_SESSION['level_id'] >= $level) {
      echo "<a href='index.php?logout=1'>Log out</a></p>";
  } else {
      header("Location: index.php");
  }
}



//controlla se sono presenti cookie di navigazione ed in caso li usa per visualizzare la pagina
function checkCookies(){
  if (array_key_exists("id", $_COOKIE)) {
      $_SESSION['id'] = $_COOKIE['id'];
      $_SESSION['level_id'] = $_COOKIE['level_id'];
  }
}



//stampa la singola riga della tabella dei log.
function printLogTable($row) {
    $html = $html."<tr><td>".$row['LABEL']."</td><td>".$row['TIMESTRAP']."</td><td>".$row['IP_ADDRESS']."</td></tr>";
  return $html;
}

?>
