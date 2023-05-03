<?php
session_start();
include('connectDB.php');
$user_id = $_SESSION['user_id'];
var_dump($user_id);


$sql = "SELECT * FROM users_table WHERE user_id = $user_id";
$result = $conn->query($sql);
var_dump($result);

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

$sql = "SELECT class_name, class_id, class_code FROM class_table WHERE professor_id = $user_id";
$result = $conn->query($sql);
$class_names = array();
$class_ids = array();
$class_codes = array();

if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $class_names[] = $row['class_name'];
        $class_ids[] = $row['class_id'];
        $class_codes[] = $row['class_code'];
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
			background-color: #444;
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
            background-color: #d3d3d3;
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
		.create-class {
			position: fixed;
			bottom: 20px;
			left: 20px;
			padding: 10px;
			background-color: #333;
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
    		background-color: #333;
    		color: #fff;
    		border: none;
            border-radius: 10px;
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
        .create-class-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .create-class-form label {
            font-size: 18px;
            font-weight: bold;
        }

        .create-class-form input[type=text] {
            font-size: 18px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .create-class-form input[type=submit] {
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
    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
<div class="container">
        <h2>My Classes</h2>
        <div class="class-grid">
            <?php 
                if (count($class_names) > 0) {
                    for ($i = 0; $i < count($class_names); $i++) {
                        echo '<a href="class_dash_prof.php?class_id=' . $class_ids[$i] . '" class="class-button">' . $class_names[$i] . '</a>';
                    }
                } else {
                    echo '<p>You have not created any classes yet.</p>';
                }
            ?>
        </div>
    </div>
<div id="createClassModal" class="modal">
    <div class="modal-content">
        <h2>Create Class</h2>
            <form class="create-class-form" action="createClass.php" method="post">
            <label for="class-name">Class Name:</label>
            <input type="text" name="class-name" id="class-name" required>
            <input type="submit" value="Create Class">
            </form>

    </div>
</div>

<!-- The "Create Class" button -->
<button class="create-class" onclick="document.getElementById('createClassModal').style.display='block'">Create Class</button>
<script>
    var modal = document.getElementById('createClassModal');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
