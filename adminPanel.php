<?php

    session_start();

    if (array_key_exists("id", $_COOKIE)) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['level_id'] = $_COOKIE['level_id'];
        
    }

    if (array_key_exists("id", $_SESSION) AND $_SESSION['level_id']==100) {
        
        echo "<p>Loggato come Amministratore! <a href='index.php?logout=1'>Log out</a></p>";
        
    } else {
        
        header("Location: index.php");
        
    }


?>