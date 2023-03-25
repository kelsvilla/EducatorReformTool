<?php
session_start();
include('connectDB.php');
// get the login information entered by the user
$username = $_POST['username'];
$password = $_POST['password'];


// validate the login information against the data in the database
$stmt = $conn->prepare("SELECT * FROM users_table WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];
    // Save role and user_id to session variables
    // User exists, check if password matches
    if (password_verify($password, $hashedPassword)) {
        // Password is correct, set session variables and redirect to success page
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role'];
        $role = $row['role'];
        if($role == "teacher"){
			header("Location: prof_dash_test.php");
		}
		else if($role == "student"){
			header("Location: student_dash_test.php");
		};
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
