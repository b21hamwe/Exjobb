<?php
try {
    $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017/");
} catch (\Exception $e) {
    echo "Error connecting to MongoDB:" . $e->getMessage();
    exit;
}


if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
?>