<?php
 $db_user = "root";
 $db_pass = "";
 $db_host = "127.0.0.1";
 $db_name = "db_connect";
 $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

 if(!$conn){
    die ("failed to connect to database" . mysqli_connect_error());
 }
if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo "{$data}";?>'s Profile</title>
  </head>
  <body>
    <h1 style="text-align: center; margin-bottom: 5%"><?php echo "$data"; ?>'s Profile</h1>

    <?php
    //execute the SQL query and return records
    $sql_owner = "SELECT * FROM owners WHERE name = '{$data}'";
    $query_owner = mysqli_query($conn, $sql_owner);
    if(!$query_owner){
        die("Query is not successful" . mysqli_error($conn));
    }
    ?>
    <div style="display: flex; justify-content: center;">
        <table style="border-collapse: separate; border-spacing: 50px 0;">
            <thead>
                <tr>
                    <th style="padding: 10px 0;">Name</th>
                    <th style="padding: 10px 0;">Address</th>
                    <th style="padding: 10px 0;">Email</th>
                    <th style="padding: 10px 0;">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query_owner)) {
                    
                    echo
                    "<tr>
            <td style=''padding: 10px 0; text-align: center'>{$row['name']}</td>
            <td style='padding: 10px 0; text-align: center'>{$row['address']}</td>
            <td style='padding: 10px 0; text-align: center'><a href='mailto:{$row['email']}'>{$row['email']}</a></td>
            <td style='padding: 10px 0; text-align: center'>{$row['phone']}</td>
            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

  </body>
</html>
