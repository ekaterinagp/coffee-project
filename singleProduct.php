<?php 
$sTitle = ' | Product name'; // Add the product dynamically
$sCurrentPage = 'shop';
require_once(__DIR__.'/components/header.php');

$iProductID = $_GET['id'];

require_once(__DIR__.'/connection.php');
$sql = "SELECT * FROM tProduct WHERE nProductID = $iProductID";
$statement = $connection->prepare($sql);

?>

<main class="single-product">
<section class="section-one grid grid-two mb-large">

<?php

if($statement->execute()){
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    $imgUrl = $product['cName'];
    $result = strtolower(str_replace(" ", "-", $imgUrl));

    echo '
    <div id="product-'.$product['nProductID'].'" class="product-info-container grid grid-two mh-large">
        <div class="image bg-cover" style="background-image: url(img/products/'.$result.'.png)"></div>
        <div class="description mh-small mv-medium">
                <h1 class="productName mv-small text-left">'.$product['cName'].'</h1>
                <p class="productPrice mv-small">'.$product['nPrice'].' DKK</p>
        </div>
    </div>
    ';
}


?>    
    <div class="product-purchase-container bg-grey p-medium grid grid-two">
        
        <div class="options">
            <h2 class="p-small">Quantity</h2>
            <h2 class="p-small">Subscription</h2>
            <h2 class="p-small">Grind</h2>
        </div>
        <div class="payment grid">
            <h2 class="align-self-bottom">Total amount</h2>
            <p class="align-self-top"><?=$product['nPrice'];?></p>
            <a href="payment.php?id=<?=$product['nProductID'];?>" class="button">Subscribe</a>
        </div>
    </div>
</section>

<section class="section-two grid mb-large">
    <h2>You might also like</h2>

</section>


</main>

<?php
$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');