<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - ADMIN Log In Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
  .form-container {
            width: 50%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
			border-radius: 10px
	}
	
	input[type=text], input[type=password] {
  width: 60%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: 5px;
  background: #FFC0CB;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #DA70D6;
  outline: 10px;
}
</style>
</head>
<body>
	<header>
    <nav>
      <div class="logo">
        <a href="index.php">
          <i class="fas fa-mug-hot" style="color: #fff; font-size: 30px;"></i>
        </a>
        <div class="logo-text">Velvet Spoon</div>
      </div>
      <ul class="nav-links">
	  <li><a href="index.php">Home</a></li>
      </ul>
    </nav>
  </header>


<?php
require('db.php');
session_start();
// If form submitted, insert values into the database.
if (isset($_POST['admin_username'])) {
    // removes backslashes
    $admin_username = stripslashes($_REQUEST['admin_username']);
    //escapes special characters in a string
    $admin_username = mysqli_real_escape_string($conn, $admin_username);
    $admin_password = stripslashes($_REQUEST['admin_password']);
    $admin_password = mysqli_real_escape_string($conn, $admin_password);
    
    // Checking if admin exists in the database or not
    // Assuming there's an `admin` table or column in the login table to distinguish admins.
    $query = "SELECT * FROM admin WHERE username='$admin_username' AND password='$admin_password'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    
    if ($rows == 1) {
        $_SESSION['admin_username'] = $admin_username;
        // Redirect admin to admin dashboard
        header("Location: admin_dashboard.php");
    } else {
        echo "<div class='form'>
        <h3>Admin Username/Password is incorrect.</h3>
        <br/>Click here to <a href='ADMIN.php'>Login</a></div>";
    }
} else {
    ?>
    <div class="form-container">
        <h2>ADMIN LOG IN</h2>
        <form action="" method="post" name="admin_login">
            <input type="text" name="admin_username" placeholder="Admin Username" required>
            <input type="password" name="admin_password" placeholder="Admin Password" required>
            <br><button type="submit" name="submit">LOG IN</button>
			<button type="reset" name="reset" > CANCEL </button>
        </form>
        <p>Not an Admin? <a href='LOG.php'>User Login Here</a></p>
    </div>
    <?php
}
?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
