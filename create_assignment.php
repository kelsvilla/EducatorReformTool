<?php
session_start();
include('connectDB.php');
$user_id =  $_SESSION['user_id'];
$class_id = $_SESSION['class_id'];
$assignment_id = 0;
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


$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Assignment</title>
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

        .create-assignment-form,
        .logout-form,
        .home-form {
            display: flex;
            align-items: center;
        }

        .create-assignment-form button,
        .logout-form button,
        .home-form button {
            background-color: #fff;
            color: #05668D;
            border: none;
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
        
        .container {
            margin-top: 140px;
            margin-left: 30px;
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
    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>

<div class="container">
    <form action="CreateAssignment.php?assignment_id=<?php echo $assignment_id ?>" method="POST">
        <label for="assignment-title">Assignment Title</label><br>
        <textarea id="assignment-title" name="assignment-title" rows="2" cols="50"></textarea><br>
        <div id="question-container">
            <div class="assignment-box">
                <label for="question-1">Question 1:</label><br>
                <textarea id="question-1" name="assignment-question[]" rows="4" cols="50"></textarea><br>
                <button type="button" class="delete-btn">Delete</button>

            </div>
        </div>
        <button type="button" id="add-question">Add Question</button>
        <button type="submit" name="submit-assignment">Submit</button>
    </form>
</div>
<script>
    function createQuestionBox() {
        const container = document.getElementById("question-container");
        const questionNum = container.children.length + 1;
        const questionBox = document.createElement("div");
        questionBox.classList.add("assignment-box");
        questionBox.innerHTML = `
            <label for="question-${questionNum}">Question ${questionNum}:</label><br>
            <textarea id="question-${questionNum}" name="assignment-question[]" rows="4" cols="50"></textarea><br>
            <button type="button" class="delete-btn">Delete</button>
        `;
        container.appendChild(questionBox);
        const deleteBtn = questionBox.querySelector(".delete-btn");
        deleteBtn.addEventListener("click", deleteQuestionBox);
    }

    function deleteQuestionBox() {
        this.parentElement.remove();
    }

    const addQuestionBtn = document.getElementById("add-question");
    addQuestionBtn.addEventListener("click", createQuestionBox);
</script>

</html>

