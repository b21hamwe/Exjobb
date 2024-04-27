<?php
// Koppling till mysql
    $mysqli = mysqli_connect("localhost", "root", "", "exjobb");


// Kolla av koppling
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }

    ?>