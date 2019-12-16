<?php
session_start();
$menuPath = "";
if ($_SESSION) {
  $menuPath = "Profile";
} else {
  $menuPath = "Log in";
}

?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,900|Open+Sans:400&display=swap" rel="stylesheet">
  <title>The Proper Pour <?php echo $sTitle; ?></title>
</head>

<body>
  <header>
    <a href="index" class="logo bg-contain">The Proper Pour Logo</a>
    <nav class="deskmenu grid <?php if ($_SESSION) echo ' logged'; ?>">
      <a href="index" class="<?php if ($sCurrentPage == 'frontpage') echo 'active'; ?>">Home</a>
      <a href="subscribe" class="<?php if ($sCurrentPage == 'subscribe') echo 'active'; ?>">Subscribe</a>
      <a href="shop" class="<?php if ($sCurrentPage == 'shop') echo 'active'; ?>">Shop</a>
      <!-- <a href="contact" class="<?php if ($sCurrentPage == 'contact') echo 'active'; ?>">Contact</a> -->
      <a class="<?php if ($sCurrentPage == strtolower($menuPath)) echo 'active'; ?>" href="<?= strtolower(str_replace(" ", "-", $menuPath)) ?>"><?= $menuPath ?></a>
      <a href="cart" id="cartItem" class=" <?php if ($sCurrentPage == 'cart') echo 'active'; ?>">Cart <div class="numberOfItems"></div></a>
      <?php if ($_SESSION) {
        echo '<a class="button-log-out" href="">Log out</a>';
      }; ?>
    </nav>
    <svg class="menuIcon justify-self-right" viewBox="0 0 100 70">
            <rect class="myrect" x="10" y="10" width="80" height="10" />
            <rect class="myrect" x="10" y="30" width="80" height="10" />
            <rect class="myrect" x="10" y="50" width="80" height="10" />
        </svg>
  </header>


  <nav class="menu hiddenMenu"> 
 <a href="index" class="<?php if ($sCurrentPage == 'frontpage') echo 'active'; ?>">Home</a>
      <a href="subscribe" class="<?php if ($sCurrentPage == 'subscribe') echo 'active'; ?>">Subscribe</a>
      <a href="shop" class="<?php if ($sCurrentPage == 'shop') echo 'active'; ?>">Shop</a>
      <!-- <a href="contact" class="<?php if ($sCurrentPage == 'contact') echo 'active'; ?>">Contact</a> -->
      <a class="<?php if ($sCurrentPage == strtolower($menuPath)) echo 'active'; ?>" href="<?= strtolower(str_replace(" ", "-", $menuPath)) ?>"><?= $menuPath ?></a>
      <a href="cart" id="cartItem" class=" <?php if ($sCurrentPage == 'cart') echo 'active'; ?>">Cart <div class="numberOfItems"></div></a>
      <?php if ($_SESSION) {
        echo '<a class="button-log-out" href="">Log out</a>';
      }; ?>
</nav> 