<?php

try {
    $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017/");
} catch (\Exception $e) {
    echo "Error connecting to MongoDB:" . $e->getMessage();
    exit;
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    //Enkel Query
    $pipeline = [
        [
            '$match' => [
                '$or' => [
                    ['id' => ['$regex' => $search]],
                    ['namn' => ['$regex' => $search]]
                ]
            ]
        ]
    ];

    //Exekvera query
    $command = new MongoDB\Driver\Command([
        'aggregate' => 'författare',
        'pipeline' => $pipeline,
        'cursor' => new stdClass(),
    ]);

    $cursor = $mongoClient->executeCommand('exjobb', $command);
    $allDocuments = $cursor->toArray();
    $documentCount = count($allDocuments);


    if ($documentCount > 0) {
        echo '<table class="fashionable-table">';
        echo '<thead>
                <tr>
                    <th>Author Id</th>  
                    <th>Author Name</th>
                </tr>
            </thead>';
        echo '<tbody>';
        foreach ($allDocuments as $document) {
            echo '<tr>
                    <td>' . $document->id . '</td>';
            echo '<td>' . $document->namn . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<h2>Data not found</h2>';
    }
}