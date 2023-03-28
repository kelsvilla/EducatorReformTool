<?php
session_start();
include('connectDB.php');
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users_table WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
} else {
    $fullname = "User Not Found";
}

$sql = "SELECT class_id, class_name FROM enrollments_table WHERE student_id = $user_id";
$result = $conn->query($sql);
$class_names = array();

if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $class_names[] = $row['class_name'];
        $class_ids[] = $row['class_id'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
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

        .class-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }

        .class-button {
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid #d9d9d9;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }

        .class-button:hover {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
            transform: translateY(-2px);
        }


		.add-class {
			position: fixed;
			bottom: 20px;
			left: 20px;
			padding: 10px;
			background-color: #00356f;
			color: #ffffff;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			font-weight: bold;
			cursor: pointer;
			transition: all .2s ease-in-out;
		}

		.add-class:hover {
			background-color: #00204a;
		}
		.logout-form {
    		display: inline-block;
    		margin-left: 10px;
		}

		.logout-form button {
    		background-color: #fff;
    		color: #05668D;
    		border: none;
    		font-size: 18px;
    		cursor: pointer;
		}
		
				        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Styles for the form inside the modal */
        .add-class-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .add-class-form label {
            font-size: 18px;
            font-weight: bold;
        }

        .add-class-form input[type=text] {
            font-size: 18px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .add-class-form input[type=submit] {
            background-color: #05668D;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
    <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
    <span><?php echo $fullname; ?></span>
    <form action="logout.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    </div>
    <div class="container">
        <h2>My Classes</h2>
        <div class="class-grid">
            <?php 
                if (count($class_names) > 0) {
                    for ($i = 0; $i < count($class_names); $i++) {
                        echo '<a href="class_dash.php?class_id=' . $class_ids[$i] . '" class="class-button">' . $class_names[$i] . '</a>';
                    }
                } else {
                    echo '<p>You are not enrolled in any classes yet.</p>';
                }
            ?>
        </div>
    </div>
<div id="addClassModal" class="modal">
    <div class="modal-content">
        <h2>Add Class</h2>
            <form class="add-class-form" action="addClass.php" method="post">
            <label for="class-code">Class Code:</label>
            <input type="text" name="class-code" id="class-code" required>
            <input type="submit" value="Add Class">
            </form>

    </div>
</div>

<!-- The "Add Class" button -->
<button class="add-class" onclick="document.getElementById('addClassModal').style.display='block'">Add Class</button>
<script>
    var modal = document.getElementById('addClassModal');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
