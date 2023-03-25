<?php
session_start();
include('connectDB.php');

// Check if user is logged in and has the teacher role
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "student") {
  header("Location: index.php");
  exit();
}

// Retrieve the user's id from the session variable
$user_id = $_SESSION['user_id'];
// Use the user's id to query the database for their information
$stmt = $conn->prepare("SELECT * FROM users_table WHERE user_id = ?");
if ($stmt === false) {
    die('Error: ' . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
/*
if(!$result){
    die("SQL query failed: " . $conn->error);
}
$row = mysqli_fetch_assoc($result);
// Use the user's information to display the page content
echo "<h1>Welcome, " . $row['fullname'] . "!</h1>";*/

 $row = $result->fetch_assoc();
 echo '<h1>Welcome, ' . $row['fullname'] . '!</h1>';

?>
