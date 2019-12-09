<?php 
$sTitle = ' | Product name'; // Add the product dynamically
$sCurrentPage = 'shop';
require_once(__DIR__.'/components/header.php');

$iProductID = $_GET['id'];

require_once(__DIR__.'/connection.php');
$sql = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, tProduct.nPrice, tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID";
$statement = $connection->prepare($sql);
?>

<main class="single-product">
    <section class="section-one grid grid-two-thirds-reversed mb-large">

<?php

if($statement->execute()){
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach($products as $product){

        if($product['bActive']!==0){

            $nProductID = $product['nProductID'];
        
            if($nProductID == $iProductID){

                $nCoffeeTypeID = $product['nCoffeeTypeID'];

                $imgUrl = $product['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
?>

        <div id="product-<?=$product['nProductID'];?>" class="product-info-container grid grid-two-thirds ml-medium">
            <div class="image bg-contain" style="background-image: url(img/products/<?= $result;?>.png)"></div>
            <div class="description mh-small mv-medium grid grid-two">
                <div>
                    <h1 class="productName mv-small text-left"><?=$product['cProductName'];?></h1>
                    <h2 class="coffee-type mv-small text-left light"><?=$product['cName'];?></h2>
                    <p class="productPrice mv-small"><?=$product['nPrice'];?> DKK</p>
                    <p>A soft, velvety body highlights a soft citric acidity and pleasant sweetness, with notes of raspberry, orange and sugar cane.</p>
                </div>
                <div class="mv-small">
                    <h4 class="uppercase bold">Roast level</h4>
                    <h3 class="uppercase light mb-small">MEDIUM ROAST</h3>
                    <h4 class="uppercase bold">Type</h4>
                    <h3 class="uppercase light mb-small"><?=$product['cName'];?></h3>
                    <h4 class="uppercase bold">Recommmended for</h4>
                    <h3 class="uppercase light">ESPRESSO</h3>
                    <h3 class="uppercase light">FRENCH PRESS</h3>
                </div>
            </div>
        </div>
    
        <div class="product-purchase-container bg-grey p-medium">   
            <div class="options-container grid grid-two">
                <div class="options">
                    <h2 class="pb-small">Quantity</h2>
                    <label for="option1">
                        <input type="number" name="option1" value="1" class="">
                        <span class="checkmark number">bag</span>    
                    </label>
                </div>
            
                
                <div class="options">
                    <h2 class="pb-small">Grind</h2>
                    <label for="option1">
                        <input type="radio" name="option1" value="0-50" class="mb-small">
                        <span class="checkmark">Whole</span>
                    </label> 
                    <label for="option1">
                        <input type="radio" name="option1" value="0-50" class="mb-small">
                        <span class="checkmark">Grind</span>
                    </label>
                </div>
            </div>
            <div class="payment">
                <h2 class="align-self-bottom">Total amount</h2>
                <p class="align-self-top"><?=$product['nPrice'];?> DKK</p>
                <a href="payment.php?id=<?=$product['nProductID'];?>" class="button">Add to cart</a>
            </div>
        </div>
    </section>

    <section class="section-two grid mb-large mh-medium">
        <h2 class="mb-medium">You might also like</h2>
        <h2 class="coffee-type text-left mb-medium"><?=$product['cName'];?></h2>
        <div class="container-banner absolute pv-large bg-dark-brown"></div>
        <div class="products-container grid grid-four">  
        
<?php
            }
        }
    }
    
    foreach($products as $product){

        if($product['bActive']!==0){

            $nProductID = $product['nProductID'];
            $nRelatedProductCoffeeTypeID = $product['nCoffeeTypeID'];

            if($nRelatedProductCoffeeTypeID == $nCoffeeTypeID && $nProductID != $iProductID){

                $imgUrl = $product['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
            ?>

                <a href="singleProduct.php?id=<?=$product['nProductID'];?>">
                    <div class="product" id="product-<?=$product['nProductID'];?>">
                    <div class="image bg-contain" style="background-image: url(img/products/<?=$result;?>.png)"></div>
                    <div class="description m-small">
                        <h3 class="productName mt-small text-left"><?=$product['cProductName'];?></h3>
                        <h4 class="productName mt-small text-left">Origin: <?=$product['cName'];?></h4>
                        <p class="productPrice mt-small"><?=$product['nPrice'];?> DKK</p>
                    </div>
                    </div>
                </a>
<?php
            }
        }
    }
}   
?>
        </div>
    </section>
</main>

<?php
$connection = null;

$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');