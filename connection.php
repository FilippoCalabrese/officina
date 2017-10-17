<?php

    $link = mysqli_connect("shareddb1d.hosting.stackcp.net", "officina", "123stella", "officina-3137abd2");
        
    if (mysqli_connect_error()) {
        
        die ("Database Connection Error");
        
    }

?>