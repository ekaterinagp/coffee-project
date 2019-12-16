<?php
$iProductID = $_GET['id'];
require_once(__DIR__ . '/connection.php');

$sqlSingleProduct = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, 
        tProduct.nPrice, tProduct.nStock, tProduct.bActive, 
        tCoffeeType.nCoffeeTypeID, tCoffeeType.cName 
        FROM tProduct INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID 
        WHERE tProduct.bActive != 0 AND tProduct.nProductID = :id";
$statementSingleProduct = $connection->prepare($sqlSingleProduct);

$sqlRelatedProducts = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, 
                        tProduct.nPrice, tProduct.nStock, tProduct.bActive, 
                        tCoffeeType.nCoffeeTypeID, tCoffeeType.cName 
                        FROM tProduct INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID 
                        WHERE tProduct.bActive != 0 AND tProduct.nCoffeeTypeID = :coffeeID AND tProduct.nProductID != :id";
$statementRelatedProducts = $connection->prepare($sqlRelatedProducts);

$data =[
    ':id' => $iProductID
    ];

if ($statementSingleProduct->execute($data)) {
        $product = $statementSingleProduct->fetch(PDO::FETCH_ASSOC);

        $nCoffeeTypeID = $product['nCoffeeTypeID'];

        $imgUrl = $product['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));

$sTitle = '| Product: '.$imgUrl; // Add the product dynamically
$sCurrentPage = 'shop';

require_once(__DIR__ . '/components/header.php');

?>

<main class="single-product">
    <section class="section-one grid grid-two-thirds-reversed mb-large ph-large mt-medium">
        <button class="back-button color-orange absolute">&lt;</button>
        <?php

                        echo '
                        <div id="product-'.$iProductID.'" class="product-info-container grid grid-two-thirds">
                            <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                            <div class="description mh-small mv-medium grid grid-two">
                                <div>
                                    <h1 class="productName mv-small text-left">'.$product['cProductName'].'</h1>
                                    <h3 class="coffee-type mv-small text-left light">'.$product['cName'].'</h3>
                                    <h4 class="productPrice mv-small">'.$product['nPrice'].' DKK</h4>
                                    <p>A soft, velvety body highlights a soft citric acidity and pleasant sweetness, with notes of raspberry, orange and sugar cane.</p>
                                </div>
                                <div class="mv-small">
                                    <h4 class="bold">Roast level</h4>
                                    <p class="light mb-small">Medium Roast</p>
                                    <h4 class="bold">Type</h4>
                                    <p class="light mb-small">'.$product['cName'].'</p>
                                    <h4 class="bold">Recommmended for</h4>
                                    <p class="light">Espresso</p>
                                    <p class="light">French Press</p>
                                </div>
                            </div>
                        </div>
                        '
                        ?>

                        <div class="product-purchase-container bg-grey p-medium pt-medium">
                            <div class="options-container grid mb-small">
                                <div class="options mv-small ">
                                    <h4 class="text-left bold pb-small">Quantity</h4>
                                   
                                    <label for="option1" class=" grid ">
                                        <input type="number" name="option1" value="1" class="">
                                        <p class="align-self-center pl-small">bag</p>
                                    </label>
                                </div>


                                <div class="options mv-small">
                                <h4 class="text-left bold pb-small">Grind</h4>
                                    <label>
                                        <input type="radio" name="grindType" value="whole" class="mb-small" checked>
                                        <div class="checkmark">Whole</div>
                                    </label>
                                    <label>
                                        <input type="radio" name="grindType" value="grind" class="mb-small">
                                        <div class="checkmark">Grind</div>
                                    </label>


                                </div>
                            </div>
                            <div class="payment">
                                <h3 class="align-self-bottom mt-medium text-right">Total amount</h3>
                                <h4 class="totalPrice align-self-top"><?= $product['nPrice']; ?> DKK</h4>
                                <button class="button" id="addToCartBtn">Add to cart</button>
                            </div>
                        </div>
    </section>

    <section class="section-two grid mv-medium ph-large relative">
        <div class="relative">
            <h2 class="bold mb-small">You might also like</h2>
            <div class="container-banner absolute pv-medium bg-dark-brown"></div>
            <div class="products-container grid grid-four">

            <?php
}
    $data =[
        ':coffeeID' => $nCoffeeTypeID,
        ':id' => $iProductID
        ];

if ($statementRelatedProducts->execute($data)) {
        $products = $statementRelatedProducts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {

        $imgUrl = $product['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
        echo 
               ' <a href="singleProduct?id='.$product['nProductID'].'">
                    <div class="product relative" id="product-'.$product['nProductID'].'">
                        <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                        <div class="description m-small">
                            <h3 class="productName mt-small text-left">'.$product['cProductName'].'</h3>
                            <h4 class="productName mt-small text-left">'.$product['cName'].'</h4>
                            <h4 class="productPrice mt-small absolute">'.$product['nPrice'].' DKK</h4>
                        </div>
                    </div>
                </a>';

    }
}
$connection = null;
?>
            </div>
        </div>
    </section>
</main>

<?php
$connection = null;

$sScriptPath = 'sessionStorageCart.js';
require_once(__DIR__ . '/components/footer.php');
