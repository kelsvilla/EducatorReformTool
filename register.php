<?php
	$servername = "localhost";
	$username = "id20384193_option1";
	$password = "1RK{nX*b?^6g-}<s";
	$dbname = "id20384193_test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the form data
$username = $_POST['username'];
$email = $_POST['email'];
$fullname = $_POST['fullname'];
$role = $_POST['role'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$error = "Invalid email format";
}

// Validate the form data
if ($password != $confirm_password) {
    echo "Passwords do not match. Please try again.";
} else {
    // Prepare the SQL statement to insert the new user data
    $sql = "INSERT INTO users_table (fullname, username, email, password, role) VALUES ('$fullname', '$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "New user registered successfully";
    } else {
        $conn->close();
        $error = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: register.php?error=" . urlencode($error));
        exit();
    }
}

// Close the database connection
$conn->close();
?>
