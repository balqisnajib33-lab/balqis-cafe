<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
require_once "db.php";

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle cart actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'add') {
    // Add items to the cart
    $code = $_GET['code'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $image = $_GET['image'];
    $quantity = 1; // Define quantity explicitly
    
    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['code'] === $code) {
            $item['quantity'] += 1; // Increase quantity if already in the cart
            $found = true;

            // Update quantity in the database
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE usersUid = ? AND code = ?");
            $stmt->bind_param("iss", $item['quantity'], $_SESSION['useruid'], $code);
            $stmt->execute();
            $stmt->close();

            break;
        }
    }
    
    // If not found, add as a new item
    if (!$found) {
        $_SESSION['cart'][] = array(
            'code' => $code,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => $quantity
        );

        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO cart (usersUid, code, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdis", $_SESSION['useruid'], $code, $name, $price, $quantity, $image);
        $stmt->execute();
        $stmt->close();
    }
	        $_SESSION['message'] = "Item successfully added to cart!";
        
        // Redirect back to the referring page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    header("Location: cart.php");
    exit();
    } elseif ($action == 'remove') {
        // Remove an item from the cart
        $code = $_GET['code'];
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['code'] === $code) {
                // Delete from the database
                $stmt = $conn->prepare("DELETE FROM cart WHERE usersUid = ? AND code = ?");
                $stmt->bind_param("ss", $_SESSION['useruid'], $code);
                $stmt->execute();
                $stmt->close();

                unset($_SESSION['cart'][$key]);
                break;
            }
        }

        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header("Location: cart.php");
        exit();
    } elseif ($action == 'clear') {
        // Clear all items from the cart
        // Clear from the database
        $stmt = $conn->prepare("DELETE FROM cart WHERE usersUid = ?");
        $stmt->bind_param("s", $_SESSION['useruid']);
        $stmt->execute();
        $stmt->close();

        $_SESSION['cart'] = array();
        header("Location: cart.php");
        exit();
    } elseif ($action == 'update') {
        // Update quantities in the cart via AJAX
        $code = $_POST['code'];
        $quantity = max(1, intval($_POST['quantity'])); // Ensure quantity is at least 1

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['code'] === $code) {
                $item['quantity'] = $quantity;

                // Update quantity in the database
                $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE usersUid = ? AND code = ?");
                $stmt->bind_param("iss", $quantity, $_SESSION['useruid'], $code);
                $stmt->execute();
                $stmt->close();

                break;
            }
        }

        echo "success"; // Response for AJAX success
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - Shopping Cart</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cart-table th, .cart-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .cart-table th {
            background-color: #f4f4f4;
        }
        .cart-table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .cart-quantity-input {
            width: 50px;
            text-align: center;
        }
        .cart-action-button, .cart-checkout-button, .cart-clear-button {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            background-color: #008cba;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #006f9a;
            cursor: pointer;
            text-align: center;
        }
        .cart-action-button:hover, .cart-checkout-button:hover, .cart-clear-button:hover {
            background-color: #006f9a;
        }
        .cart-remove-button {
            background-color: #e74c3c;
            border: 1px solid #c0392b;
        }
        .cart-remove-button:hover {
            background-color: #c0392b;
        }
        .cart-checkout-button, .cart-clear-button {
            width: 100%;
            text-align: center;
        }
    </style>
    <script>
        function updateCartQuantity(code, quantity) {
            // Send AJAX request to update the cart
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cart.php?action=update", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == "success") {
                        // Reload the page to reflect updated quantities
                        location.reload();
                    }
                }
            };
            xhr.send("code=" + encodeURIComponent(code) + "&quantity=" + encodeURIComponent(quantity));
        }
    </script>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="cart-container">
    <h2>Your Shopping Cart</h2>
    <?php if (!empty($_SESSION['cart'])) { ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>RM <?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" class="cart-quantity-input" value="<?php echo $item['quantity']; ?>" min="1" onchange="updateCartQuantity('<?php echo htmlspecialchars($item['code']); ?>', this.value)">
                        </td>
                        <td>RM <?php echo number_format($itemTotal, 2); ?></td>
                        <td><a href="cart.php?action=remove&code=<?php echo urlencode($item['code']); ?>" class="cart-action-button cart-remove-button">Remove</a></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" align="right"><strong>Total Price:</strong></td>
                    <td>RM <?php echo number_format($totalPrice, 2); ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
		<center><h3> WE ONLY ACCEPT :   <i class="fab fa-cc-mastercard" style="color: #ff1a75; font-size: 30px;"></i>
		<i class="fab fa-cc-visa" style="color: #ff1a75; font-size: 30px;"></i>
		<i class="far fa-credit-card" style="color: #ff1a75; font-size: 30px;"></i>
		<i class="far fa-money-bill-alt" style="color: #ff1a75; font-size: 30px;"></i></center> </h3>

		
        <a href="checkout.php" class="cart-checkout-button">Proceed to Checkout</a>
        <a href="cart.php?action=clear" class="cart-clear-button">Clear Cart</a>
    <?php } else { ?>
        <p>Your cart is empty. </p>
    <?php } ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>