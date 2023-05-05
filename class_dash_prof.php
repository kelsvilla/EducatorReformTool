<?php
session_start();
include('connectDB.php');
$user_id =  $_SESSION['user_id'];
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} else {
    echo "Error: Class ID not specified in URL";
    exit();
}
$_SESSION['class_id'] = $class_id;
$className = "None";

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


$stmt = $conn->prepare("SELECT * FROM assignments_table WHERE class_id = ?");
$stmt->bind_param("s", $class_id);
$stmt->execute();
$assignments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .header {
            background-color: #444;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header h3 {
            margin: 0;
            font-size: 20px;
        }
        
        .class-code {
            position: fixed;
            bottom: 0px;
            right: 0px;
            padding: 10px;
        }

        .header span {
            font-size: 18px;
        }

        .create-assignment-form,
        .logout-form,
        .home-form {
            display: flex;
            align-items: center;
        }

        .create-assignment-form button,
        .logout-form button,
        .view-feedback button,
        .home-form button {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        .home-form {
            margin-right: auto;
        }

        .logo {
            margin: 0;
            width: 100px;
            height: 100px;
        }
        
        .assignment-container {
            margin-top: 150px;
        }

        .assignment-box {
            border: 1px solid black;
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }

        .header h1,
        .header h2,
        .header h3 {
            margin: 0;
            flex-grow: 1;
            text-align: center;
        }

        .header h2,
        .header h3 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
    <h1><?php echo $className; ?></h1>
    <form action ="prof_dash_test.php" class="home-form">
        <button type="submit" name="home">Home</button>
    </form>

    <form action="create_assignment.php" method="POST" class="create-assignment-form">
        <button type="submit" name="Create Assignment">Create</button>
    </form>

    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
<div class="assignment-container">
    <?php foreach ($assignments as $assignment): ?>
        <div class="assignment-box">
            <?php echo '<a href="view-feedback.php?assignment_id=' . $assignment['assignment_id'] . '" class=".view-feedback-button">' . $assignment['assignment_title'] . '</a>'; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="class-code">
    <?php echo "Class code: ", $class_code; ?>
</div>
</html>
