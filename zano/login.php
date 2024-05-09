<?php
session_start(); // Start session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Change this to your MySQL server name if it's different
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password if you have one
    $database = "zano"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get username and password from the form
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt password using md5, you should consider using more secure encryption like bcrypt

    // SQL query to fetch user from 'zainab' table
    $sql = "SELECT * FROM zainab WHERE username='$username' AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, set session variables
        $_SESSION['username'] = $username;
        header("Location: table.php"); // Redirect to table.php after successful login
        exit(); // Stop further execution
    } else {
        // User not found, display error message
        $error_message = "Invalid username or password!";
    }

    $conn->close(); // Close connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php if(isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>
