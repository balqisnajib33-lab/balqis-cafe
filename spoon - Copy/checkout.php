<?php
// Mulakan sesi jika diperlukan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
require_once "db.php";

if (!isset($_SESSION['checkout'])) {
    $_SESSION['checkout'] = array();
}

// Handle checkout action
if (isset($_POST['action']) && $_POST['action'] == 'checkout') {
    $payment = $_POST['payment']; // Ambil kaedah pembayaran
    $status = $_POST['status']; // Status pesanan, boleh ditukar mengikut keperluan

    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO checkout ( usersUid, payment, status) VALUES ( ?, ?, ?)");
    $stmt->bind_param("sss", $_SESSION['useruid'], $payment, $status);
    $stmt->execute();
    $stmt->close();


    // Kosongkan cart selepas checkout
    $_SESSION['cart'] = array();

    $_SESSION['message'] = "Pesanan berjaya dibuat!";
    header("Location: thankyou.php"); // Arahkan ke halaman pengesahan pesanan
    exit();
}

?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - Checkout</title>
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
	label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

    select {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
	</style>
</head>
<body>

<?php include 'navbar.php'; ?>
<center>
<div class="form-container">
    <h2>Checkout</h2>

    <form action="" method="POST">
        <input type="hidden" name="action" value="checkout">

	    <div class="form-group">
        <label for="payment">Payment Method: </label>
        <select id="payment" name="payment" required>
                <option value="cimbbank">CIMB BANK</option>
                <option value="maybank">MAYBANK</option>
                <option value="rhbbank">RHB BANK</option>
				<option value="ambank">AM BANK</option>
				<option value="bankislam">BANK ISLAM</option>
				<option value="touchngo">Touch 'n Go</option>
				<option value="grabpay">GrabPay</option>
                <option value="pay_at_counter_cash">Pay at counter-Cash</option>
        </select>
		<br><br>
        <div class="form-group">
            <label for="status">Take Out / Dine In</label>
            <select id="status" name="status" required>
                <option value="dine_in">Dine In</option>
                <option value="take_out">Take Out</option>
            </select>
        </div>
		<br>
		<button type="submit" class="submit" onclick="window.location.href='thankyou.php';">Proceed</button>
        <button type="reset" class="reset" onclick="window.location.href='cart.php';">Cancel</button>

    </form>
</div>
</center>
<?php include 'footer.php'; ?>

</body>
</html>