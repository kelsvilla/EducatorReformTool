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
$className = "None";
var_dump($user_id);

$stmt = $conn->prepare("SELECT * FROM class_table WHERE class_id = ?");
$stmt->bind_param("s", $class_id);
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
    $className = $row['class_name'];
}



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
            background-color: #05668D;
            color: #ffffff;
            padding: 10px;
            font-size: 24px;
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

        .header span {
            float: right;
            font-size: 18px;
            margin-top: 30px;
        }

        .container {
            margin: 130px 20px 20px 20px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            border: none;
        }
        
        .logo {
            margin: 0;
            width: 100px;
            height: 100px;
        }
        
        .assignment-box {
            border: 1px solid black;
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }
        
    </style>
</head>
<body>
<div class="header">
    <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
    <h1><?php echo $className; ?></h1>
    <a href="student_dash_test.php"><button>Home</button></a>
    <form action="logout.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
<div class="container">
    <div class="assignment-container">
        <div class="assignment-box">
          Assignment 1
        </div>
        <div class="assignment-box">
          Assignment 2
        </div>
        <div class="assignment-box">
          Assignment 3
        </div>
    </div>
</div>

</body>
</html>

