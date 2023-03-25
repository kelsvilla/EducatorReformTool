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

		.class-card {
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

		.class-card:hover {
			background-color: #ffffff;
			box-shadow: 0 2px 8px rgba(0,0,0,.15);
			transform: translateY(-2px);
		}

		.create-class {
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
    <div class="class-grid">
        <div class="class-card">Class 1</div>
    </div>
</div>
<button class="create-class">Create Class</button>
</body>
</html>
