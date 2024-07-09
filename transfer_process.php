<?php
// Database connection
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['ID']) && isset($_POST['to']) && isset($_POST['credit'])) {
        $from = $_GET['ID'];
        $to = $_POST['to'];
        $credit = $_POST['credit'];

        // Fetch sender details
        $stmt = $conn->prepare("SELECT * FROM all_user1 WHERE ID = ?");
        $stmt->bind_param("i", $from);
        $stmt->execute();
        $sql1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Fetch receiver details
        $stmt = $conn->prepare("SELECT * FROM all_user1 WHERE ID = ?");
        $stmt->bind_param("i", $to);
        $stmt->execute();
        $sql2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Check for negative input
        if ($credit < 0) {
            echo '<script type="text/javascript">alert("Oops! Negative values cannot be Transferred")</script>';
        }
        // Check for insufficient amount
        else if ($credit > $sql1['amount']) {
            echo '<script type="text/javascript">alert("Oops! Insufficient Amount")</script>';
        }
        // Check for zero values
        else if ($credit == 0) {
            echo '<script type="text/javascript">alert("Oops! Zero value cannot be Transferred")</script>';
        } else {
            // Deduct credit from sender's account
            $newamount = $sql1['amount'] - $credit;
            $stmt = $conn->prepare("UPDATE all_user1 SET amount = ? WHERE ID = ?");
            $stmt->bind_param("di", $newamount, $from);
            $stmt->execute();
            $stmt->close();

            // Add credit to receiver's account
            $newamount = $sql2['amount'] + $credit;
            $stmt = $conn->prepare("UPDATE all_user1 SET amount = ? WHERE ID = ?");
            $stmt->bind_param("di", $newamount, $to);
            $stmt->execute();
            $stmt->close();

            // Record the transaction
            $stmt = $conn->prepare("INSERT INTO transactions (sender_id, receiver_id, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $from, $to, $credit);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('Transaction Successful'); window.location='index.php';</script>";
        }
    } else {
        echo '<script>alert("Invalid request parameters.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
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

    <!-- Fetch selected user ID details -->
    <?php
    if (isset($_GET['id'])) {
        $sid = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM all_user1 WHERE ID = ?");
        $stmt->bind_param("i", $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "Error: User not found.";
        } else {
            $row = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        echo "Error: Missing user ID.";
    }
    ?>

    <?php if (isset($row)) : ?>
    <div class="all_users">
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>AMOUNT</th>
            </tr>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['amount'] ?></td>
            </tr>
        </table>
    </div>

    <form class="transferprocess" method="POST">
        <select id="select" name="to" required>
            <option disabled selected>TRANSFER MONEY TO</option>
            <?php
            $stmt = $conn->prepare("SELECT * FROM all_user1 WHERE ID != ?");
            $stmt->bind_param("i", $sid);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo '<option value="'.$row["ID"].'">'.$row["name"].' (CURRENT BALANCE: '.$row["amount"].')</option>';
            }
            $stmt->close();
            ?>
        </select>
        <input type="number" name="credit" placeholder="AMOUNT" required>
        <button type="submit">TRANSFER</button>
    </form>
    <?php endif; ?>

    <?php include '_footer.php'; ?>
    <!-- script -->
    <script src="navscroll.js"></script>
</body>
</html>
