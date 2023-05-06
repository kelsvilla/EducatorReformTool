<?php
session_start();
include('connectDB.php');
$user_id =  $_SESSION['user_id'];
$class_id = $_SESSION['class_id'];
$questions = [];

$stmt = $conn->prepare("SELECT * FROM class_table WHERE class_id = ?");
$stmt->bind_param("s", $class_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    $error = "Error: " . mysqli_error($conn);
    header("Location: view-feedback.php?error=" . urlencode($error));
    exit();
}

// Prepare the SQL statement to retrieve user data for the entered username
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $className = $row['class_name'];
}


if (isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];
} else {
    echo "Error: Assignment ID not specified in URL";
    exit();
}
$_SESSION['assignment_id'] = $assignment_id;
$assignmentName = "None";

$stmt = $conn->prepare("SELECT * FROM questions_table WHERE assignment_id = ?");
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// check for errors
if ($result === false) {
$error = "Error: " . mysqli_error($conn);
header("Location: view-feedback.php?error=" . urlencode($error));
exit();
}

$stmt = $conn->prepare("SELECT * FROM ratings_table WHERE assignment_id = ?");
$stmt->bind_param("s", $assignment_id);
$stmt->execute();
$ratings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


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
        
        .header span {
            font-size: 18px;
        }

        .logout-form,
        .home-form {
            display: flex;
            align-items: center;
        }

        .logout-form button,
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
        
        .question-container {
            margin-top: 150px;
        }

        .question-box {
            border: 1px solid black;
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }

        .rating-container {
            border: 1px solid black;
            background-color: white;
            padding: 10px;
            margin-top: 10px;
        }
        
        .rating-box { 
            border: 1px solid black;
            background-color: #c1cdcd;
            padding: 10px;
            margin-bottom: 10px;

        }
        .average-rating {
            font-weight: bold;
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

    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
<div class="question-container">
    <?php foreach ($questions as $question) { ?>
        <div class="question-box">
            <div class="question">
                <?php echo $question['question_data']; ?>
            </div>
        </div>

        <div class="ratings-container">
            
            <?php
            $total_rating = 0;
            $num_ratings = 0;
            foreach ($ratings as $rating) {
                if ($rating['question_id'] == $question['question_id']) {
                    ?>
                    <div class="rating-box">
                    <?php
                    $total_rating += $rating['student_rating'];
                    $num_ratings++;
                    echo "<div class='review'>";
                    echo "<p>" . $rating['student_review'] . "</p>";
                    echo "<p>Rating: " . $rating['student_rating'] . "</p>";
                    echo "</div>";
                    ?>
                    </div>
                    <?php
                }
            }
            ?>
            </div>
            <?php
            if ($num_ratings > 0) {
                $average_rating = $total_rating / $num_ratings;
                echo "<div class='average-rating'>";
                echo "<p>Average Rating: " . round($average_rating, 1) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    <?php } ?>
</div>

</html>
