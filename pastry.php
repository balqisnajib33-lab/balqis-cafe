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
  <title>Velvet Spoon - Pastry Menu</title>  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>

	.button {
  background-color: #FFF8DC;
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: #f1daf1; 
  color: #6a1b9a; 
  border: 2px solid #f1daf1 ;
}

.button1:hover {
  background-color: #6a1b9a;
  color: white;
}
	</style>
</head>
<body>
<?php include 'navbar.php'; ?>
  
<?php  
require_once "db.php";
$query = "SELECT * FROM `pastry`"; 
$result = mysqli_query($conn, $query);
?>
 <div class="menu-container">
    <h1>Our Delicious Pastries</h1>
    <div class="pastry-grid">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="pastry-item">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
				<h4><?php echo htmlspecialchars($row['description']); ?></h4>
                <div class="price">RM <?php echo htmlspecialchars($row['price']); ?></div>
                <?php 
                if (isset($_SESSION["useruid"])) {
                    echo '<a href="cart.php?action=add&code='.urlencode($row['code']).'&name='.urlencode($row['name']).'&price='.urlencode($row['price']).'&image='.urlencode($row['image']).'&description='.urlencode($row['description']).'"> <button class="add-to-cart ; button button1">Add to Cart</button></a>';
                } else {
                    echo '<a href="LOG.php" <button class="add-to-cart ; button button1">Login to Add to Cart</button></a>';
                }
                ?>
            </div>
        <?php } ?>

    </div>
</div>


<?php include 'footer.php'; ?>
</body>
</html>
