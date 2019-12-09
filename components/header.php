<?php
session_start();
$menuPath = "";
if ($_SESSION) {
  $menuPath = "Profile";
} else {
  $menuPath = "Login";
}

?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:300,900|Open+Sans:300&display=swap" rel="stylesheet">
  <title>The Proper Pour <?php echo $sTitle; ?></title>
</head>

<body>
  <header>
    <!-- <img src="img/the-proper-pour-logo.svg" class="imgLogo" alt="The Proper Pour logo">     -->
    <a href="index.php" class="logo bg-contain">The Proper Pour Logo</a>
    <nav class="deskmenu grid">
      <a href="index.php" class="<?php if ($sCurrentPage == 'frontpage') echo 'active'; ?>">Home</a>
      <a href="subscribe.php" class="<?php if ($sCurrentPage == 'subscribe') echo 'active'; ?>">Subscribe</a>
      <a href="shop.php" class="<?php if ($sCurrentPage == 'shop') echo 'active'; ?>">Shop</a>
      <a href="contact.php" class="<?php if ($sCurrentPage == 'contact') echo 'active'; ?>">Contact</a>
      <a class="<?php if ($sCurrentPage == 'profile') echo 'active'; ?>" href="<?= strtolower($menuPath) ?>.php"><?= $menuPath ?></a>
      </a>
      <a href="cart.php" class=" <?php if ($sCurrentPage == 'cart') echo 'active'; ?>">Cart</a>
    </nav>

  </header>