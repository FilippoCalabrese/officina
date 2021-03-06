<?php


//redireziona l'utente all'appropriata pagina di amministrazione / visualizzazione
function redirectToCorrectPage()
{
    if (($_SESSION['level_id'] == 999) or ($_COOKIE['level_id'] == 999)) {
        header('Location: superAdminPanel.php');
    } elseif (($_SESSION['level_id'] == 100) or ($_COOKIE['level_id'] == 100)) {
        header('Location: adminPanel.php');
    } else {
        header('Location: loggedinpage.php');
    }
}

//verifica se l'utente si è loggato con credenziali appropriate a visualizzare la pagina
function verifyPermission($level)
{
    if (array_key_exists('id', $_SESSION) and $_SESSION['level_id'] >= $level) {
        echo "<nav class='navbar navbar-dark bg-dark'>
                <a class='navbar-brand' style='color: white; font-weight: bold;'>BT CAR</a>
                  <ul class='navbar-nav'>
                    <liclass='nav-link'><button class='btn btn-danger'><a href='index.php?logout=1'  style='color: black; font-weight: bold'>ESCI</a></button></li>
                  </ul>
                </nav>";
    } else {
        header('Location: index.php');
    }
}

//controlla se sono presenti cookie di navigazione ed in caso li usa per visualizzare la pagina
function checkCookies()
{
    if (array_key_exists('id', $_COOKIE)) {
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['level_id'] = $_COOKIE['level_id'];
    }
}

//stampa la singola riga della tabella dei log.
function printLogTable($row)
{
    $html = $html.'<tr><td>'.$row['LABEL'].'</td><td>'.$row['TIMESTRAP'].'</td><td>'.$row['IP_ADDRESS'].'</td></tr>';

    return $html;
}
