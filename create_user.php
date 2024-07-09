<?php
include '_dbconnect.php'; // Ensure the database connection file is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    // Check if the email already exists
    $existSql = "SELECT * FROM `all_user1` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $numExistRow = mysqli_num_rows($result);

    if ($numExistRow > 0) {
        // If user already exists
        $message = "Email Already Exists!! Please use another email.";
    } else {
        // Insert new user data using prepared statement
        $stmt = mysqli_prepare($conn, "INSERT INTO `all_user1` (`name`, `email`, `amount`) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $amount);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $message = "Congrats! New User Added Successfully.";
        } else {
            $message = "Failed to add new user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt); // Close prepared statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD USER</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>
    <?php include '_navbar.php'; ?>
    <div class="cover"></div>
    <div class="create">
        <h1>CREATE &nbsp; USER</h1>
        <div class="createUser">
            <div class="userimg">
                <img src="bank.jpg" alt="user image">
            </div>
            <div class="userdata">
                <!-- Display feedback message -->
                <?php if (isset($message)) : ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>

                <!-- Create user Form -->
                <form method="POST">
                    <input id="name" type="text" placeholder="NAME" name="name" required>
                    <input id="email" type="email" placeholder="EMAIL" name="email" required>
                    <input id="amount" type="number" placeholder="AMOUNT" name="amount" required>
                    <button type="submit">ADD USER</button>
                </form>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
    <!-- scripts  -->
    <script src="navscroll.js"></script>
</body>

</html>
