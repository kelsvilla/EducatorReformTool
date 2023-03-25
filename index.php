<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
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
      input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: none;
        background-color: #444;
        color: #fff;
      }
      input[type="text"]::placeholder, input[type="password"]::placeholder {
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
      .forgot-password {
        margin-top: 10px;
        font-size: 14px;
      }
      .forgot-password button {
        background-color: transparent;
        color: #4CAF50;
        border: none;
        text-decoration: underline;
        cursor: pointer;
        margin: 0;
      }
      .forgot-password button:focus {
        outline: none;
      }
      .logo {
        display: block;
        width: 200px;
        height: 200px;
        margin-bottom: 20px;
      }
      .error {
                color: red;
                margin-top: 10px;
            }
    </style>
</head>
<body>
<form method="POST" action="login.php">
  <img src="https://i.ibb.co/PtpLtVP/Logo.png" alt="Logo" class="logo">
  <input type="text" id="username" name="username" placeholder="Username" required>
  <input type="password" id="password" name="password" placeholder="Password" required>
  <div class="button-container">
    <input type="submit" value="Login">
    <a href="registration.php"><input type="button" value="Register" class="secondary"></a>
  </div>
  <div class="forgot-password">
    <button>Forgot username or password?</button>
    <?php if(isset($_GET['error'])) { ?>
            <div class="error"><?php echo $_GET['error']; ?></div>
        <?php } ?>
  </div>
</form>
</body>
</html>
