<?php

$mysqli = mysqli_connect("localhost", "root", "", "exjobb");

// Kolla efter uppkoppling mot db
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

?>