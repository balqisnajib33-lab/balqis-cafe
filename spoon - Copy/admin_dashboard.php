<?php
// Start session and check if the user is logged in as admin
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location:ADMIN.php");
    exit();
}

require('db.php');


if (isset($_POST['delete_user'])) {
    // Handle deleting user
    $usersId = $_POST['usersId'];

    if ($usersId == 'usersId') {
        $query = "DELETE FROM admin WHERE id = $id";
    } else {
        $query = "DELETE FROM users WHERE usersId = $usersId";
    }
	
if (mysqli_query($conn, $query)) {
    // If the query is successful
    echo "<script type='text/javascript'>alert('User deleted successfully!');</script>";
} else {
    // If the query fails, you might want to handle the error
    echo "<script type='text/javascript'>alert('Error deleting user: " . mysqli_error($conn) . "');</script>";
}

}

if (isset($_POST['edit_user'])) {
    // Handle editing admin
    $id = $_POST['usersId']; // Assuming 'dd' contains the admin ID
    $usersname = mysqli_real_escape_string($conn, $_POST['usersName']);
    $email = mysqli_real_escape_string($conn, $_POST['usersEmail']);

    // Update password only if provided
    $password_query = "";
    if (!empty($_POST['usersPwd'])) {
        $password = mysqli_real_escape_string($conn, $_POST['usersPwd']); // Store plain text password
        $password_query = ", password = '$password'";
    }

    // Prepare the SQL query to update the admin
    $query = "UPDATE users SET usersName = ?, usersEmail = ? $password_query WHERE usersId = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind parameters
        if (!empty($_POST['password'])) {
            mysqli_stmt_bind_param($stmt, "ssi", $usersname, $email, $id); // "ssi" indicates string, string, integer
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $email); // "ss" indicates string, string
        }

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the query is successful
            echo "<script type='text/javascript'>alert('Admin updated successfully!');</script>";
        } else {
            // If the query fails, handle the error
            echo "<script type='text/javascript'>alert('Error updating admin: " . mysqli_error($conn) . "');</script>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script type='text/javascript'>alert('Failed to prepare statement.');</script>";
    }
}

if (isset($_POST['edit_admin'])) {
    // Handle editing admin
    $id = $_POST['id']; // Assuming 'dd' contains the admin ID
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update password only if provided
    $password_query = "";
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($conn, $_POST['password']); // Store plain text password
        $password_query = ", password = '$password'";
    }

    // Prepare the SQL query to update the admin
    $query = "UPDATE admin SET username = ?, email = ? $password_query WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind parameters
        if (!empty($_POST['password'])) {
            mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $id); // "ssi" indicates string, string, integer
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $email); // "ss" indicates string, string
        }

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the query is successful
            echo "<script type='text/javascript'>alert('Admin updated successfully!');</script>";
        } else {
            // If the query fails, handle the error
            echo "<script type='text/javascript'>alert('Error updating admin: " . mysqli_error($conn) . "');</script>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script type='text/javascript'>alert('Failed to prepare statement.');</script>";
    }
}


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

if (isset($_POST['delete_checkout'])) {
    // Handle deleting user
    $checkout_id = $_POST['checkout_id'];

     if ($checkout_id == 'checkout_id') {
        $query = "DELETE FROM checkout WHERE checkout_id = $checkout_id";
    } else {
        $query = "DELETE FROM checkout WHERE checkout_id = $checkout_id";
    }
	
if (mysqli_query($conn, $query)) {
    // If the query is successful
    echo "<script type='text/javascript'>alert('User record deleted successfully!');</script>";
} else {
    // If the query fails, you might want to handle the error
    echo "<script type='text/javascript'>alert('Error deleting user record: " . mysqli_error($conn) . "');</script>";
}

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - ADMIN Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
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
	    <li><a href="logout.php"> <i class="fas fa-sign-out-alt">Log Out</i></a></li>
		
	</nav>
</header>

<center><h1>Admin Dashboard</h1></center>



<!-- Display Admin List -->
<center><h2>List of Admins</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th> <!-- Display plain text password -->
		<th>Actions</th>
    </tr>

    <?php
    // Query to fetch and display admins based on search term and search field
    if (!empty($search_term)) {
        $query = "SELECT * FROM admin WHERE $search_field LIKE '%$search_term%'";
    } else {
        $query = "SELECT * FROM admin";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['password'] . "</td>";  // Displaying plain text password
		 echo "<td>
                <form method='post' action='admin_dashboard.php' style='display:inline-block'>
                    <label>Name:</label>
                    <input type='text' name='username' value='" . $row['username'] . "' required>
                    <label>Email:</label>
                    <input type='text' name='email' value='" . $row['email'] . "' required>
                    <label>Password (New):</label>
                    <input type='password' name='password' placeholder='New Password (optional)'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='role' value='admin'>
                    <input type='submit' name='edit_admin' value='Edit'>
                </form>
            </td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- Display Customer List -->
<h2>List of Customers</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th> <!-- Display plain text password -->
         <th>Actions</th>
    </tr>

  <?php
    // Query to fetch and display admins based on search term and search field
    if (!empty($search_term)) {
        $query = "SELECT * FROM users WHERE $search_field LIKE '%$search_term%'";
    } else {
        $query = "SELECT * FROM users";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['usersId'] . "</td>";
        echo "<td>" . $row['usersName'] . "</td>";
        echo "<td>" . $row['usersEmail'] . "</td>";
        echo "<td>" . $row['usersUid'] . "</td>";  // Displaying plain text password
       echo "<td>
                <form method='post' action='admin_dashboard.php' style='display:inline-block'>
                    <input type='hidden' name='usersId' value='" . $row['usersId'] . "'>
                    <input type='hidden' name='role' value='customer'>
                    <input type='submit' name='delete_user' value='Delete'>
                </form>
                <form method='post' action='admin_dashboard.php' style='display:inline-block'>
                    <label>Username:</label>
                    <input type='text' name='usersName' value='" . $row['usersName'] . "' required>
                    <label>Email:</label>
                    <input type='text' name='usersEmail' value='" . $row['usersEmail'] . "' required>
                    <label>Password (New):</label>
                    <input type='password' name='password' placeholder='New Password (optional)'>
                    <input type='hidden' name='usersId' value='" . $row['usersId'] . "'>
                    <input type='hidden' name='role' value='customer'>
                    <input type='submit' name='edit_user' value='Edit'>
                </form>
            </td>";
        echo "</tr>";
    }
    ?>
</table>

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

<h2>CHECK OUT CUSTOMERS RECORD</h2>
<table border="1">
    <tr>
		<th> Checkout ID </th>
		<th> Users Name </th>
		<th> Payment </th>
        <th> Status </th>
        <th> Action</th>
    </tr>

  <?php
    // Query to fetch and display admins based on search term and search field
    if (!empty($search_term)) {
        $query = "SELECT * FROM checkout WHERE $search_field LIKE '%$search_term%'";
    } else {
        $query = "SELECT * FROM checkout";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
		echo "<td>" . $row['checkout_id'] . "</td>";
		echo "<td>" . $row['usersUid'] . "</td>";
        echo "<td>" . $row['payment'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
		echo "<td>
            <form method='post' action='admin_dashboard.php' style='display:inline-block'>
                <input type='hidden' name='checkout_id' value='" . htmlspecialchars($row['checkout_id']) . "'>
                <input type='submit' name='delete_checkout' value='Delete'>
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
