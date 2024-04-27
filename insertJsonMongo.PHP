<?php

$mysqli = mysqli_connect("localhost", "root", "", "exjobb");

// Kolla efter uppkoppling mot db
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

//Hämta allt från tabellen
$sql = "SELECT * FROM `författare`";
$result = mysqli_query($mysqli, $sql);


// Se om query funkar
if (!$result) {
    echo "Error: " . mysqli_error($mysqli);
    exit();
}


?>