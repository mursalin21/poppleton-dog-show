<?php
 $db_user = "root";
 $db_pass = "";
 $db_host = "127.0.0.1";
 $db_name = "db_connect";
 $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

 if(!$conn){
    die ("failed to connect to database" . mysqli_connect_error());
 }
 
 ?>
 <!DOCTYPE html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <title>Poppleton Dog Show</title>
    <link href="style/index-layout.css" rel="stylesheet" type="text/css" />
    <link href="style/homepage-layout.css" rel="stylesheet" type="text/css"/>
 </head>
 <body>

    <?php
    //execute the SQL query and return records
    $sql_dogs = 'SELECT * FROM dogs';
    $query_dogs = mysqli_query($conn, $sql_dogs);
    if(!$query_dogs){
        die("Query is not successful" . mysqli_error($conn));
    }

    $sql_owners_total = 'SELECT COUNT(*) as total FROM owners';
    $query_owners_total = mysqli_query($conn, $sql_owners_total);
    $data_owners_total = mysqli_fetch_assoc($query_owners_total);

    if(!$query_owners_total){
        die("Query is not successful" . mysqli_error($conn));
    }

    $sql_dogs_total = 'SELECT COUNT(*) as total FROM dogs';
    $query_dogs_total = mysqli_query($conn, $sql_dogs_total);
    $data_dogs_total=mysqli_fetch_assoc($query_dogs_total);

    if(!$query_dogs_total){
        die("Query is not successful" . mysqli_error($conn));
    }

    $sql_events_total = 'SELECT COUNT(*) as total FROM events';
    $query_events_total = mysqli_query($conn, $sql_events_total);
    $data_events_total=mysqli_fetch_assoc($query_events_total);

    

    if(!$query_events_total){
        die("Query is not successful" . mysqli_error($conn));
    }

    $sql_table_joined = "SELECT dog_id, ROUND(AVG(DISTINCT score), 2) as avg_score, breeds.name as breed, dogs.name as dog_name, owners.name as owner_name, owners.email as owner_email \n"

    . "FROM entries \n"

    . "JOIN dogs \n"

    . "ON dogs.id = entries.dog_id\n"

    . "JOIN owners\n"

    . "ON owners.id = dogs.owner_id\n"

    . "JOIN breeds\n"

    . "ON breeds.id = dogs.breed_id\n"

    . "GROUP BY dog_id\n"

    . "HAVING COUNT(*) > 1 \n"

    . "ORDER BY avg_score DESC\n"

    . "LIMIT 10;";

    $query_table_joined = mysqli_query($conn, $sql_table_joined);

    

    if(!$query_events_total){
        die("Query is not successful" . mysqli_error($conn));
    }
    ?>

    <h1 style="text-align: center; margin-bottom: 5%;">“Welcome to Poppleton Dog Show! This year <?php echo "<span>{$data_owners_total['total']}</span>" ?> owners entered <?php echo "<span>{$data_dogs_total['total']}</span>" ?> dogs in <?php echo "<span>{$data_events_total['total']}</span>" ?> events!”.</h1>
    <div style="display: flex; justify-content: center;">
        <table style="border-collapse: separate; border-spacing: 50px 0;">
            <thead>
                <tr>
                    <th style="padding: 10px 0;">Dog's Name</th>
                    <th style="padding: 10px 0;">Breed</th>
                    <th style="padding: 10px 0;">Average Score</th>
                    <th style="padding: 10px 0;">Owner's Name</th>
                    <th style="padding: 10px 0;">Owner's Email</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query_table_joined)) {
                    $email = $row['owner_email'];
                    
                    echo
                    "<tr>
            <td style=''padding: 10px 0; text-align: center'>{$row['dog_name']}</td>
            <td style='padding: 10px 0; text-align: center'>{$row['breed']}</td>
            <td style='padding: 10px 0; text-align: center'>{$row['avg_score']}</td>
            <td style='padding: 10px 0; text-align: center'><a href='personPage.php?data={$row['owner_name']}'>{$row['owner_name']}</a></td>
            <td style='padding: 10px 0; text-align: center'><a href='mailto:{$row['owner_email']}'>{$row['owner_email']}</a></td>
            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
 </body>
 </html>
<?php mysqli_close($conn); ?>