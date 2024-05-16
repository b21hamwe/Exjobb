<style>
    /* CSS Styling for the table */
    .fashionable-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fashionable-table th, .fashionable-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .fashionable-table th {
        background-color: #f2f2f2;
    }

    .fashionable-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .fashionable-table tbody tr:hover {
        background-color: #ddd;
    }
</style>

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
                'from' => 'författare',
                'localField' => 'bok.id',
                'foreignField' => 'id',
                'as' => 'författare'
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
                'författare' => '$id',
                'bok' => '$bok',
                
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
    foreach ($allDocuments as $document) {
        // Accessing 'författare' field directly
        $authorName = isset($document->författare) ? $document->författare : 'N/A';
    
        echo '<tr>
                <td>' . (isset($document->bok) ? $document->bok->id : 'N/A') . '</td>'; // Accessing 'id' from 'bok'
                echo '<td>' . $authorName . '</td>';
                echo '<td>' . (isset($document->bok) ? $document->bok->boktitel : 'N/A') . '</td>'; // Accessing 'boktitel' from 'bok'
                echo '<td>' . (isset($document->bokserie[0]) ? $document->bokserie[0]->serietitel : 'N/A') . '</td>'; // Accessing 'serietitel' from the first element of 'bokserie'
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<h2>Data not found</h2>';

    }
}
?>