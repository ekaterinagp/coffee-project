<?php
$sTitle = ' | Thank you'; // Add the product dynamically
$sCurrentPage = 'Thank you';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="thank-you">
<section class="section-three mb-large ph-large pt-medium">
      <div class="related-products relative">
      <h1 class="text-center p-small">Thank you for your purchase</h1>
      <h4 class="text-center pt-small pb-medium">Estimated time of delivery is one day from now.</h4>
        <h2 class="coffee-type mb-medium">Back to shop</h2>
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
           <div class="product" id="product-'.$jProduct['nProductID'].'">
               <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
               <div class="description m-small">
                   <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
                   <h4 class="productName mt-small text-left">Origin: '.$jProduct['cName'].'</h4>
                   <h4 class="productPrice mt-small">'.$jProduct['nPrice'].' DKK</h4>
               </div>
           </div>
       </a>';
    }
}
?>
<!-- <a href="shop" class="m-small link"> Back to shop</a> -->
<!-- <a href="shop" class=" m-small link"> Back to subscribe options</a> -->
</main>
<?php

$connection = null;
require_once(__DIR__ . '/components/footer.php');
