<?php
	$servername = "localhost";
	$username = "root";
	$password = "GMG2023";
	$dbname = "test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// If form is submitted, insert values into database
	if(isset($_POST['submit'])) {
		
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		
		if(empty($errors)) {
			$sql = "INSERT INTO users_table (fullname, username, email, password, role) VALUES ('$fullname', '$username', '$email', '$password', '$role')";

			if ($conn->query($sql) === TRUE) {
				// Redirect to home page
				header("Location: home.php");
				exit();
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			// Display errors if there are any
			foreach($errors as $error) {
				echo "<p>$error</p>";
			}
		}
	}

$conn->close();
?>
