<?php
session_start();
// unset all session variables
session_unset();
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

// Check if the username or email already exists in the database
$sql = "SELECT * FROM users_table WHERE username='$username' OR email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User already exists, set error message and redirect back to register page
    $error = "Username or email already exists. Please try again.";
    $conn->close();
    header("Location: registration.php?error=" . urlencode($error));
    exit();
}


// Validate the form data
if ($password != $confirm_password) {
    $error = "Passwords do not match. Please try again.";
    $conn->close();
    header("Location: registration.php?error=" . urlencode($error));
    exit();
} 
else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  
    // Prepare the SQL statement to insert the new user data
    $sql = "INSERT INTO users_table (fullname, username, email, password, role) VALUES ('$fullname', '$username', '$email', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        // Password is correct, set session variables and redirect to success page
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
		if($role == 'teacher'){
			header("Location: prof_dash_test.php");
		}
		else if($role == 'student'){
			header("Location: student_dash_test.php");
		}
		else{
        header("Location: index.php");
		}
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
