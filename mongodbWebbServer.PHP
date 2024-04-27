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

    $command = new MongoDB\Driver\Command([
        'aggregate' => 'författare',
        'pipeline' => $pipeline,
        'cursor' => new stdClass(),
    ]);


$cursor = $mongoClient->executeCommand('exjobb2', $command);
$allDocuments = iterator_to_array($cursor);
$documentCount = count($allDocuments);

if ($documentCount > 0) {
    echo '<table class="fashionable-table">';
    echo '<thead>
            <tr>
                <th>Book Id</th>  
                <th>Author Name</th>
                <th>Book Title</th>  
                <th>Serie Title</th>
            </tr>
        </thead>';
    echo '<tbody>';

}
?>