<?php
session_start();
include('connectDB.php');

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
} 

else {
    // Prepare the SQL statement to insert the new user data
    $sql = "INSERT INTO users_table (fullname, username, email, password, role) VALUES ('$fullname', '$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Password is correct, set session variables and redirect to success page
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
		if($role == "Professor"){
			header("Location: prof_home.php")
		}
		else if($role == "Student"){
			header("Location: homepage.php");
		}
        header("Location: home.php");
        exit();
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
