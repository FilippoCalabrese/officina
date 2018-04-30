<?php

    $link = mysqli_connect("localhost", "officina", "Fondamentale14", "officina");
    date_default_timezone_set('Europe/Rome');

    if (mysqli_connect_error()) {
        die('Database Connection Error');
    }
