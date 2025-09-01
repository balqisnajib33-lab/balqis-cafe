<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
require_once "db.php";

// Check if there's a message to display
if (isset($_SESSION['message'])) {
    echo "<script type='text/javascript'>
        alert('" . $_SESSION['message'] . "');
    </script>";
    unset($_SESSION['message']); // Clear the message after displaying it
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<center>
    <div style="width:700px; margin:50 auto;">
        <h2>Thank You for Your Order!</h2>
        <p>Your order has been placed successfully. We appreciate your business!</p>
        <p>You will receive a confirmation email shortly. <i class="fas fa-envelope-open-text" style="color: #d24dff; font-size: 30px;"></i></p>
</center>
    </div>
	<?php include 'footer.php'; ?>
</body>
</html>
