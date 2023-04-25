<?php
session_start();
include('connectDB.php');

$user_id = $_SESSION['user_id'];
$class_id = $_SESSION['class_id'];

$className = "None";
$assignment_name = "None";





$stmt = $conn->prepare("SELECT * FROM class_table WHERE class_id = ?");
$stmt->bind_param("s", $class_id);
$stmt->execute();
$result = $stmt->get_result();

// check for errors
if ($result === false) {
    $error = "Error: " . mysqli_error($conn);
    header("Location: prof_dash_test.php?error=" . urlencode($error));
    exit();
}

// Prepare the SQL statement to retrieve user data for the entered username
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $className = $row['class_name'];
    $class_code = $row['class_code'];
}

if (isset($_POST['submit-assignment'])) {
    $assignment_title = $_POST['assignment-title'];
    $assignment_questions = $_POST['assignment-question'];
    
    $stmt = $conn->prepare("INSERT INTO assignments_table (assignment_title, class_id) VALUES (?, ?)");
    $stmt->bind_param("si", $assignment_title, $class_id);
    $stmt->execute();

    // Get the assignment_id of the new assignment
    $assignment_id = $stmt->insert_id;


    $stmt = $conn->prepare("INSERT INTO questions_table (question_title, question_data, assignment_id, class_id) VALUES (?, ?, ?, ?)");

    foreach ($assignment_questions as $question) {
        $stmt->bind_param("ssii", $assignment_title, $question, $assignment_id, $class_id);
        $stmt->execute();
    }

    // check for errors
    if ($stmt === false) {
        $error = "Error: " . mysqli_error($conn);
        header("Location: class_dash_prof.php?error=" . urlencode($error));
        exit();
    }
    else{
        header("Location: class_dash_prof.php?class_id=$class_id");
    }
    $stmt->close();
}

$conn->close();

?>
