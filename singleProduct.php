<?php 
$sTitle = ' | Product name'; // Add the product dynamically
$sCurrentPage = 'shop';
require_once(__DIR__.'/components/header.php');

$iProductID = $_GET['id'];

require_once(__DIR__.'/connection.php');
$sqli = "SELECT * FROM tProduct";
$sql = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, tProduct.nPrice, tProduct.nStock, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID";
$statement = $connection->prepare($sql);
?>

<main class="single-product">
    <section class="section-one grid grid-two mb-large">

<?php

if($statement->execute()){
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach($products as $product){

        $nProductID = $product['nProductID'];
        
        if($nProductID == $iProductID){

            $nCoffeeTypeID = $product['nCoffeeTypeID'];

            $imgUrl = $product['cProductName'];
            $result = strtolower(str_replace(" ", "-", $imgUrl));
?>

        <div id="product-<?=$product['nProductID'];?>" class="product-info-container grid grid-two mh-large">
            <div class="image bg-contain" style="background-image: url(img/products/<?= $result; ?>.png)"></div>
            <div class="description mh-small mv-medium">
                    <h1 class="productName mv-small text-left"><?=$product['cProductName'];?></h1>
                    <h2 class="coffee-type mv-small text-left"><?=$product['cName'];?></h2>
                    <p class="productPrice mv-small"><?=$product['nPrice'];?> DKK</p>
            </div>
        </div>

    
        <div class="product-purchase-container bg-grey p-medium grid grid-two">
            
            <div class="options">
                <h2 class="p-small">Quantity</h2>

                <label for="option1" class="mr-small">
                        <input type="number" name="option1" value="0-50" class="mr-small mb-small">
                        <span class="checkmark">bag</span>    
                </label>

                
            
                <h2 class="p-small">Grind</h2>
                <div class="options">
                    <label for="option1" class="mr-small">
                        <input type="radio" name="option1" value="0-50" class="mr-small mb-small">
                        <span class="checkmark">Whole</span>
                    </label> 

                    <label for="option1" class="mr-small">
                        <input type="radio" name="option1" value="0-50" class="mr-small mb-small">
                        <span class="checkmark">Grind</span>
                    </label>
                </div>
               
            </div>
            <div class="payment grid">
                <h2 class="align-self-bottom">Total amount</h2>
                <p class="align-self-top"><?=$product['nPrice'];?> DKK</p>
                <a href="payment.php?id=<?=$product['nProductID'];?>" class="button">Add to cart</a>
            </div>
        </div>
    </section>

    <section class="section-two grid mb-large mh-medium">
        <h2 class="mb-medium">You might also like</h2>
        <h2 class="coffee-type text-left mb-small"><?=$product['cName'];?></h2>
        <div class="products-container grid grid-four">
        

<?php
        }
        
    }
    
    foreach($products as $product){
        $nProductID = $product['nProductID'];

        $imgUrl = $product['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));

        $nRelatedProductCoffeeTypeID = $product['nCoffeeTypeID'];

        if($nRelatedProductCoffeeTypeID == $nCoffeeTypeID && $nProductID != $iProductID){?>

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
?>
        </div>
    </section>
</main>

<?php
$sScriptPath = 'js/script.js';
require_once(__DIR__.'/components/footer.php');