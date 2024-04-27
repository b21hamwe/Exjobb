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

}