<?php
// Start session and check if the user is logged in as admin
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location:ADMIN.php");
    exit();
}

require('db.php');

if (isset($_POST['delete_order'])) {
    // Handle deleting order
    $order_id = $_POST['order_id'];


    // Prepare the SQL query to prevent SQL injection
    $query = "DELETE FROM cart WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "i", $order_id); // "i" indicates the type is integer
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the query is successful
            echo "<script type='text/javascript'>alert('Order deleted successfully!');</script>";
        } else {
            // If the query fails, handle the error
            echo "<script type='text/javascript'>alert('Error deleting order: " . mysqli_error($conn) . "');</script>";
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script type='text/javascript'>alert('Failed to prepare statement.');</script>";
    }
}
?> 

<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - List Of Orders</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  
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
	    <li><a href="logout.php"> <i class="fas fa-sign-out-alt">Log Out</i></a></li>
		<li><a href="L.orders.php">LIST OF ORDERS </a></li>
		<li><a href="checkout_record.php">CHECK OUT CUSTOMERS RECORD </a></li>
		<li><a href="admin_dashboard.php"> ADMIN DASHBOARD</a></li>
	</nav>
</header>

<center>
<h2>List of Orders</h2>
<table border="1">
    <tr>
		<th> Order ID </th>
		<th> Users Name</th>
        <th> Code </th>
        <th> Name </th>
        <th> Quantity </th>
		<th> Price </th>
        <th> Action</th>
    </tr>

  <?php
    // Query to fetch and display admins based on search term and search field
    if (!empty($search_term)) {
        $query = "SELECT * FROM cart WHERE $search_field LIKE '%$search_term%'";
    } else {
        $query = "SELECT * FROM cart";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
		echo "<td>" . $row['order_id'] . "</td>";
		echo "<td>" . $row['usersUid'] . "</td>";
        echo "<td>" . $row['code'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td>
            <form method='post' action='admin_dashboard.php' style='display:inline-block'>
                <input type='hidden' name='order_id' value='" . htmlspecialchars($row['order_id']) . "'>
                <input type='submit' name='delete_order' value='Delete'>
            </form>
          </td>";
        echo "</tr>";
    }
    ?>
</table>
</center>

<?php include 'footer.php'; ?>
</body>
</html>
