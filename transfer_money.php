<?php
include '_dbconnect.php';

// Query to select all users
$sql = "SELECT * FROM all_user1";
$result = mysqli_query($conn, $sql);

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
    <title>TRANSFER MONEY</title>
</head>

<body>
    <?php include '_navbar.php'; ?>

    <div class="cover"></div>

    <h1>TRANSFER &nbsp; MONEY</h1>
    <div class="all_users" style="height: 500px;">
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>AMOUNT</th> <!-- Changed from BALANCE to AMOUNT -->
                <th>OPERATION</th>
            </tr>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <tr>
                    <td>'.$row['ID'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['amount'].'</td> <!-- Changed from balance to amount -->
                    <td id="transfer"><a href="transfer_process.php?id='.$row['ID'].'"><button type="button">TRANSFER</button></a></td> 
                </tr>
                ';
            }
            ?>
        </table>
    </div>

    <?php include '_footer.php'; ?>
    <!-- script  -->
    <script src="navscroll.js"></script>
</body>
</html>
