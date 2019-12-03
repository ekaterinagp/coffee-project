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
                <a href="index.php" class="<?php if($sCurrentPage == 'frontpage') echo 'active';?>">Home</a>
                    <a href="subscribe.php" class="<?php if($sCurrentPage == 'subscribe') echo 'active';?>">Subscribe</a>
                    <a href="shop.php" class="<?php if($sCurrentPage == 'shop') echo 'active';?>">Shop</a>
                    <a href="how-to.php" class="<?php if($sCurrentPage == 'how-to') echo 'active';?>">How-To</a>
                    <a href="contact.php" class="<?php if($sCurrentPage == 'contact') echo 'active';?>">Contact</a>
                    <a href="profile.php" class="profile menu-icon bg-contain <?php if($sCurrentPage == 'profile') echo 'active';?>">Profile</a>
                    <a href="cart.php" class="cart menu-icon bg-contain" <?php if($sCurrentPage == 'cart') echo 'active';?>>Cart</a> 
            </nav>
    
        </header>