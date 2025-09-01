<!DOCTYPE html>
<html>
<head>
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
        <li><a href="LOG.php">Log In</a></li>
		<li><a href="register.php">Sign Up</a></li>
      </ul>
    </nav>
  </header>
<div class="form-container">
<section class="sign-up">
	<h2>Sign Up</h2>
	<form action="register.inc.php" method="post">
		<input type="text" name="name" placeholder="Full name...">
		<input type="text" name="email" placeholder="Email...">
		<input type="text" name="uid" placeholder="Username...">
		<input type="password" name="pwd" placeholder="Password...">
		<input type="password" name="pwdrepeat" placeholder="Repeat password...">
		<br><button type="submit" name="submit">Sign Up</button>
	</form>
	<?php 
if (isset($_GET["error"])) {
	if ($_GET["error"] == "emptyinput") {
	echo "<p>Fill in all fields!</p>";
	}
	else if ($_GET["error"] == "invalidUid") {
	echo "<p>Choose a proper username!</p>";
	}
	else if ($_GET["error"] == "invalidemail") {
	echo "<p>Choose a proper email!</p>";
	}
	else if ($_GET["error"] == "passwordsdontmatch") {
	echo "<p>Passwords don't match!</p>";
	}
	else if ($_GET["error"] == "stmtfailed") {
	echo "<p>Something went wrong, try again!</p>";
	}
	else if ($_GET["error"] == "usernametaken") {
	echo "<p>Username already taken!</p>";
	}
	else if ($_GET["error"] == "none") {
	echo "<p>You have signed up!</p>";
	}
}

 ?>
</section>

</div>
<?php include 'footer.php'; ?>
</body>
</html>