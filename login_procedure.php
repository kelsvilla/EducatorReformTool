<?php
	$servername = "localhost";
	$username = "id20384193_option1";
	$password = "1RK{nX*b?^6g-}<s";
	$dbname = "id20384193_test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

// check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the login information entered by the user
$username = $_POST['username'];
$password = $_POST['password'];

// validate the login information against the data in the database
$sql = "SELECT * FROM users_table WHERE username='$username' AND password='$password'";
// Prepare the SQL statement to retrieve user data for the entered username

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User exists, check if password matches
    $row = $result->fetch_assoc();
    if ($row['password'] == $password) {
        // Password is correct, set session variables and redirect to success page
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        header("Location: success_page.php");
        exit();
    } else {
        // Password is incorrect, redirect back to login form with error message
        $conn->close();
        $error = "Invalid login credentials. Please try again.";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }
} else {
    // User does not exist, redirect back to login form with error message
    $conn->close();
    $error = "Invalid login credentials. Please try again.";
    header("Location: index.php?error=" . urlencode($error));
    exit();
}

// Close the database connection
$conn->close();
?>
