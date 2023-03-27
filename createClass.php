<?php
session_start();
include('connectDB.php');

// Get the new class name and code from the previous file in the session
$newClassName = $_POST['class-name'];
$randomCode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
$currProf = $_SESSION['user_id'];

// Prepare the SQL statement with placeholders
$stmt = $conn->prepare("INSERT INTO class_table (class_name, class_code, professor_id) VALUES (?, ?, ?)");

// Bind the parameters to the placeholders
$stmt->bind_param("ssi", $newClassName, $randomCode, $currProf);

// Execute the statement
if ($stmt->execute()) {
    // Class added successfully, redirect to dashboard
    header("Location: prof_dash_test.php");
} else {
    // Error occurred, display message and redirect to previous page
    echo "Error adding class: " . $stmt->error;
    header("Location: prof_dash_test.php");
}

$conn->close();
?>
