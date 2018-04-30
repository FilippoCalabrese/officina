<?php

<<<<<<< HEAD
    $link = mysqli_connect("localhost", "officina", "Fondamentale14", "officina");
    date_default_timezone_set('Europe/Rome');
=======
    $link = mysqli_connect('localhost', 'root', 'root', 'officina');
>>>>>>> d78c408f51015aba7c2742531da0b5c893713e0a

    if (mysqli_connect_error()) {
        die('Database Connection Error');
    }
