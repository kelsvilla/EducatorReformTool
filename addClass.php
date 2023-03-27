<?php
session_start();
include('connectDB.php');

// Get the new class name and code from the previous file in the session
$newClassCode = $_POST['class-code'];
$currStudent = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM class_table WHERE class_code = ?");
$stmt->bind_param("s", $newClassCode);
$stmt->execute();
$result = $stmt->get_result();

// check for errors
if ($result === false) {
    $error = "Error: " . mysqli_error($conn);
    header("Location: student_dash_test.php?error=" . urlencode($error));
    exit();
}

// Prepare the SQL statement to retrieve user data for the entered username
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $classID = $row['class_id'];
    $className = $row['class_name'];
}

// Prepare the SQL statement with placeholders
$stmt = $conn->prepare("INSERT INTO enrollments_table (class_id, student_id, class_name) VALUES (?, ?, ?)");

// Bind the parameters to the placeholders
$stmt->bind_param("iis", $classID, $currStudent, $className);

// Execute the statement
if ($stmt->execute()) {
    // Class added successfully, redirect to dashboard
    header("Location: student_dash_test.php");
} else {
    // Error occurred, display message and redirect to previous page
    echo "Error adding class: " . $stmt->error;
    header("Location: student_dash_test.php");
}

$conn->close();
?>
