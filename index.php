<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Velvet Spoon - HOME</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'navbar.php'; ?>
  <div class="highlight-image"></div>

  <section class="hero">
    <h1>Welcome to Velvet Spoon</h1>
    <p>Explore our delicious pastries and coffee.</p>
  </section>

  <!-- Image Slider Section with 10 Images -->
  <section class="image-slider">
    <div class="slider">
      <img src="puff.jpg" alt="">
      <img src="cromboloni.jpg" alt="Coffee Image 2">
      <img src="danish.jpeg" alt="Coffee Image 3">
      <img src="white.jpg" alt="Coffee Image 4">
      <img src="croissanty.jpg" alt="Coffee Image 5">
      <img src="cream.jpeg" alt="Coffee Image 6">
      <img src="chocolate.jpg" alt="Coffee Image 7">
      <img src="spinach.jpg" alt="Coffee Image 8">
      <img src="easy.jpg" alt="Coffee Image 9">
      <img src="chox.jpeg" alt="Coffee Image 10">
    </div>
  </section>

<?php include 'footer.php'; ?>

</body>
</html>
