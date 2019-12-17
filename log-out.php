<?php
$sTitle = ' | Thank you for your visit'; // Add the product dynamically
$sCurrentPage = 'Thank you';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="log-out thank-you">
<section class="section-three mb-large ph-large pt-medium">
      <div class="related-products relative">
      <h1 class="text-center p-small">Thank you for your visit</h1>
      <h3 class="text-center pt-small mb-medium">We hope to see you again soon!</h3>

    <h2 class="coffee-type mb-small">Want to browse our newest products?</h2>
    <h3 class="coffee-type mb-medium">Visit the shop and discover a world of quality coffee</h3>

    <a href="shop"><h2 class="coffee-type mb-medium uppercase">Go to shop</h2></a> 
        <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
        <div class="products-container grid grid-four">
<?php
$sqlProducts = "SELECT tProduct.nProductID, tProduct.cName AS cProductName, 
tProduct.nCoffeeTypeID AS nProductCoffeeTypeID, tProduct.nPrice, 
tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName 
FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID WHERE tProduct.bActive != 0 LIMIT 4";
$statementProducts = $connection->prepare($sqlProducts);

if ($statementProducts->execute()) {
    $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($jProducts as $jProduct) {
      $imgUrl = $jProduct['cProductName'];
      $result = strtolower(str_replace(" ", "-", $imgUrl));

      echo 
      ' <a href="singleProduct?id='.$jProduct['nProductID'].'">
           <div class="product relative" id="product-'.$jProduct['nProductID'].'">
               <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
               <div class="description m-small">
                   <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
                   <h4 class="productName mt-small text-left">'.$jProduct['cName'].'</h4>
                   <h4 class="productPrice mt-small absolute">'.$jProduct['nPrice'].' DKK</h4>
               </div>
           </div>
       </a>';
    }
}



?>
<script src="js/thankyou.js"></script>
</main>
<?php
$sScriptPath ="sessionStorageCart.js";
$connection = null;
require_once(__DIR__ . '/components/footer.php');
