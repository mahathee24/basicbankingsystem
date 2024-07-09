<?php
$servername = "localhost";
$username = "root";
$password = ""; // Use your actual password
$dbname = "tsf_bank";
$port = 3306; // Use 3306 if MySQL is running on the default port

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if(!$connection){
    die("Error: " . mysqli_connect_error());
} else {
    echo 'Connection established';
}

// Fetch users
$query = "SELECT ID, name, email, amount FROM all_user1"; // Adjust the table and column names as necessary
$result = mysqli_query($connection, $query);

// Check query result
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="table.css">
    <title>ALL USERS</title>
</head>

<body>
    <?php include '_navbar.php'; ?>

    <div class="cover"></div>
    
    <h1>ALL &nbsp; USERS</h1>
    <div class="all_user" style="height: 500px;">
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>AMOUNT</th>
            </tr>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <tr>
                    <td>".$row['ID']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['amount']."</td>
                </tr>
                ";
            }
            ?>
        </table>
    </div>

    <?php include '_footer.php'; ?>
    <!-- script -->
    <script src="navscroll.js"></script>
</body>

</html>
