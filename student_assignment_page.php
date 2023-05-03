<?php
session_start();
include('connectDB.php');
$user_id =  $_SESSION['user_id'];
$questions = [];
if (isset($_SESSION['class_id'])) {
    $class_id = $_SESSION['class_id'];
} else {
    echo "Error: Class ID not set";
    exit();
}
$className = "None";

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

$assignment_id = $_GET['assignment_id'];

$stmt = $conn->prepare("SELECT * FROM questions_table WHERE assignment_id = ?");
$stmt->bind_param("s", $assignment_id);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$question_title = "No questions added to assignment yet.";

foreach ($questions as $question): 
    $question_title = $question['question_title'];
endforeach;

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Assignment Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .header {
            background-color: #444444;
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
            margin-left: 10px;
            margin-right: 10px;
        }
        
        .question-box {
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
        
        .review-box {
            border: 1px solid black;
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }
        
        
</style>
</head>
<div class="header">
    <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
    <h1><?php echo $question_title ?></h1>
    <form action ="student_dash_test.php" class="home-form">
        <button type="submit" name="home">Home</button>
    </form>
    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
<div class="question-container">
  <form action="assignment_review.php" method="POST">
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id ?>">
    <?php foreach ($questions as $question): ?>
      <div class="question-box">
        <?php echo htmlspecialchars($question['question_data']) ?>
        <input type="hidden" name="question_id[]" value="<?php echo $question['question_id'] ?>">
        <label for="rating">Rating:</label>
        <input type="number" name="rating[]" id="rating" min="1" max="5" required>
        <br>
        <label for="review">Review:</label>
        <textarea name="review[]" id="review" required></textarea>
        <br>
      </div>
    <?php endforeach; ?>
    <button type="submit" name="submit">Submit</button>
  </form>
</div>



</body>
</html>