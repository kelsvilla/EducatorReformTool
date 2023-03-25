<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <style>
      body {
        background-color: #333;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: Arial, sans-serif;
      }
      form {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border-radius: 10px;
        background-color: #222;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      }

        input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: none;
        background-color: #444;
        color: #fff;
      }
      
        input::placeholder {
        color: #ccc;
      }
      
      input[type="submit"], input[type="button"] {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        margin: 10px;
      }
      input[type="button"].secondary {
        background-color: #2e2e2e;
      }
      .button-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
      }
      .logo {
        display: block;
        width: 200px;
        height: 200px;
        margin-bottom: 20px;
      }
      .radio-buttons-container {
        display: flex;
        flex-direction: row;
        align-items: center;
      }
      .radio-button-label {
        margin-right: 10px;
        width: 50px;
        font-size: 16px;
      }

      input[type="radio"] {
        margin-right: 5px;
        width: 15px;
      }

      input[type="radio"] + label {
        font-size: 16px;
      }
      
    </style>
</head>
<body>
<form method="POST" action="register.php">
    <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
    <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
    <input type="text" id="username" name="username" placeholder="Username" required>
    <input type="email" id="email" name="email" placeholder="Email" required>
    <input type="password" id="password" name="password" placeholder="Password" required>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Retype Password" required>
    <div class="radio-buttons-container">
        <span class="radio-button-label">I am a:</span>
        <input type="radio" id="role" name="role" value="teacher" required>
        <label for="teacher">Teacher</label>
        <input type="radio" id="role" name="role" value="student" required>
        <label for="student">Student</label>
    </div>
    <div class="button-container">
        <input type="submit" value="Register">
        <a href="index.php"><input type="button" value="Return" class="secondary"></a>
    </div>
</form>
</body>
</html>