<?php
try {
    $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017/");
} catch (\Exception $e) {
    echo "Error connecting to MongoDB:" . $e->getMessage();
    exit;
}


if (isset($_POST['search'])) {
    $search = $_POST['search'];

    //Medel Query
    $pipeline = [
        [
            '$lookup' => [
                'from' => 'bok',
                'localField' => 'id',
                'foreignField' => 'id',
                'as' => 'bok'
            ]
        ],
        [
            '$unwind' => '$bok'
        ],
        [
            '$lookup' => [
                'from' => 'bokserie',
                'localField' => 'bok.id',
                'foreignField' => 'id',
                'as' => 'bokserie'
            ]
        ],
        [
            '$match' => [
                '$or' => [
                    ['id' => ['$regex' => $search]], // Match författare id
                    ['namn' => ['$regex' => $search]] // Match författare namn
                ]
            ]
        ],
        [
            '$project' => [
                'författare' => '$namn',
                'bok' => '$bok',
                'bokserie' => '$bokserie'
            ]
        ]
    ];

}
?>