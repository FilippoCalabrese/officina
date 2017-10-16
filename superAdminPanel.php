<?php

    session_start();

    if (array_key_exists("id", $_COOKIE)) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        $_SESSION['level_id'] = $_COOKIE['level_id'];
        
    }

    if (array_key_exists("id", $_SESSION) AND $_SESSION['level_id']==999) {
        
        echo "<p>Loggato come Super Admin! <a href='index.php?logout=1'>Log out</a></p>";
        
    } else {
        
        header("Location: index.php");
        
    }


?>