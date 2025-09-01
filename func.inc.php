<?php

// Function to check if any input is empty
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Function to validate username using regular expression
function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Function to validate email
function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Function to check if passwords match
function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Function to check if a user exists based on username or email
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: register.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

// Function to create a new user
function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: register.php?error=stmtfailed");
        exit();
    }
    
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("location: register.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd1) {
	$uidExists = uidExists($conn, $username, $username);
	
	if ($uidExists === false) {
	header("location: LOG.php?error=wrongusername");
    exit();	
	}
	
	$pwdHashed = $uidExists["usersPwd"];
	$checkPwd = password_verify($pwd1, $pwdHashed);
	
	if ($checkPwd === false) {
	header("location: LOG.php?error=wrongpass");
    exit();		
	}
	else if (($checkPwd === true)) {
		session_start();
		$_SESSION["userid"] = $uidExists["usersId"];
		$_SESSION["useruid"] = $uidExists["usersUid"];
		fetchCartFromDatabase($conn, $_SESSION["useruid"]);
		header("location: index.php");
		exit();	
	}
}

function fetchCartFromDatabase($conn, $usersUid) {
    // Fetch cart items from the database for the logged-in user
    $stmt = $conn->prepare("SELECT code, name, price, quantity, image FROM cart WHERE usersUid = ?");
    $stmt->bind_param("s", $usersUid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Initialize session cart
    $_SESSION['cart'] = array();

    // Fetch each row and add to the session cart
    while ($row = $result->fetch_assoc()) {
        $_SESSION['cart'][] = array(
            'code' => $row['code'],
            'name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'image' => $row['image']
        );
    }

    $stmt->close();
}


?>
