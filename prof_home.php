<?php
session_start();
include('connectDB.php');

// Check if user is logged in and has the teacher role
if(!isset($_SESSION['username']) || $_SESSION['role'] != "teacher") {
  echo $_SESSION['username'], ", ", $_SESSION['role'];
  exit();
}

// Retrieve the user's id from the session variable
$username = $_SESSION['username'];
// Use the user's id to query the database for their information
$stmt = $conn->prepare("SELECT * FROM users_table WHERE username = ?");
if ($stmt === false) {
    die('Error: ' . $conn->error);
}
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();
if(!$result){
    die("SQL query failed: " . $conn->error);
}
$row = mysqli_fetch_assoc($result);

// Use the user's information to display the page content
echo "<h1>Welcome, " . $row['fullname'] . "!</h1>";
?>
