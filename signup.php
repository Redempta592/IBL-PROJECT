<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $username = $_POST['username'];
    $password = $_POST['password'];
 

    // Validate the form data (e.g., check for empty fields, validate email format)

    // Database connection details
    $servername = "localhost";
    $dbUsername = "your_username";
    $dbPassword = "your_password";
    $dbname = "your_database_name";

    // Create a database connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $user);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username is already taken
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($checkUsernameQuery);
    if ($result->num_rows > 0) {
        $errorMessage = "Username is already taken. Please choose a different username.";
    } else {
        // Insert the user data into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($insertUserQuery) === TRUE) {
            // Registration successful, redirect to login page
            header('Location: login.php');
            exit;
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="signup2.html" href="signup2.html">
</head>
<body>
    <h1>Sign Up</h1>
    <?php if (isset($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
