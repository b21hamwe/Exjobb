<style>
    /* CSS Styling för klienten */
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
// Koppling till mysql
    $mysqli = mysqli_connect("localhost", "root", "", "exjobb");


// Kolla av koppling
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }


    if(isset($_POST['search'])){
        $search = $_POST['search'];


    //Svår Query
    $sql = "SELECT * FROM `författare` 
    JOIN `bok` ON författare.id = bok.id
    JOIN `bokserie` ON bok.id = bokserie.id
    WHERE författare.id LIKE '%$search%' OR författare.namn LIKE '%$search%'";

    //Enkel Query
    //$sql = "SELECT * FROM `författare` WHERE författare.id LIKE '%$search%' OR författare.namn LIKE '%$search%'";

$result = mysqli_query($mysqli, $sql);


//Presentation av MYSQL data
if($result && mysqli_num_rows($result) > 0) {
    echo '<table class="fashionable-table">';
    echo '<thead>
                  <tr>
                      <th>Author Id</th>  
                      <th>Author name</th>
                      <th>Book title</th>  
                      <th>Serie title</th>
                  </tr>
              </thead>';
              echo '<tbody>';
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>
                          <td>'.$row['id'].'</td>
                          <td>'.$row['namn'].'</td>
                          <td>'.$row['boktitel'].'</td>
                          <td>'.$row['serietitel'].'</td>
                        </tr>';
              }
              echo '</tbody>';
              echo '</table>';
          } else {
              echo '<h2>Data not found</h2>';
    }
}

    mysqli_close($mysqli);
    
    ?>