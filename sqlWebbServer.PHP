<?php
// Koppling till mysql
    $mysqli = mysqli_connect("localhost", "root", "", "exjobb");


// Kolla av koppling
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }


    if(isset($_POST['search'])){
        $search = $_POST['search'];


 //Medel Query
 $sql = "SELECT * FROM `författare` 
 JOIN `bok` ON författare.id = bok.id
 JOIN `bokserie` ON bok.id = bokserie.id
 WHERE författare.id LIKE '%$search%' OR författare.namn LIKE '%$search%'";

 //Enkel Query
 //$sql = "SELECT * FROM `författare` WHERE författare.id LIKE '%$search%' OR författare.namn LIKE '%$search%'";

$result = mysqli_query($mysqli, $sql);


    }
    ?>