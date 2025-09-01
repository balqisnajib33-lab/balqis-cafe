  <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
	  <li><a href="index.php"><i class="fas fa-home"> Home </i></a></li>
	    <li><a href="store.php"><i class="fas fa-phone"> Contact Us</i></a></li>
        <li><a href="about.php"><i class="fa fa-info-circle"> Our Story</i></a></li>
        <li>
          <a> <i class="far fa-edit"> Menu</i> <i class="fas fa-caret-down"></i></a>
          <div class="dropdown">
            <a href="pastry.php">Pastry</a>
            <a href="coffee.php">Coffee</a>
          </div>
        </li>
		<li>
           <a><i class="fas fa-user"> Account </i><i class="fas fa-caret-down"></i></a>
          <div class="dropdown">
                <?php 
                if (isset($_SESSION["useruid"])) {
                    echo '<a href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a>';
                } else {
                    echo '<a href="LOG.php"> USER </a>';
                    echo '<a href="register.php"> SIGN UP </a>';
					echo '<a href="ADMIN.php"> ADMIN </a>';
                }
                ?>
            </div>
		</li>
		<li>
<a>
				<?php 
                if (isset($_SESSION["useruid"])) {
                    echo '<a href="cart.php" title="Cart"><i class="fas fa-shopping-cart"></i>';
                } else {
                 echo '<a href="LOG.php" <i class="fas fa-shopping-cart"></i>';
                }
                ?>
				
        
        </a>
		</li>
      </ul>

    </nav>
  </header>
    	      <script>
const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            if (navLinks.classList.contains('active')) {
                navLinks.style.display = 'flex';
                navLinks.style.flexDirection = 'column';
            } else {
                navLinks.style.display = 'none';
            }
        });

        
        document.addEventListener('click', function(event) {
            const isClickInside = navLinks.contains(event.target) || menuToggle.contains(event.target);
            if (!isClickInside && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                navLinks.style.display = 'none';
            }
        });
	</script>