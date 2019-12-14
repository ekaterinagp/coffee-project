<?php
$sTitle = ' | Shop';
$sCurrentPage = 'shop';

require_once(__DIR__ . '/connection.php');
$sql = "SELECT tProduct.nProductID, tProduct.cName AS cProductName, tProduct.nCoffeeTypeID AS nProductCoffeeTypeID, 
        tProduct.nPrice, tProduct.nStock, tProduct.bActive, 
        tCoffeeType.nCoffeeTypeID, tCoffeeType.cName 
        FROM tProduct INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID WHERE tProduct.bActive != 0";

$statement = $connection->prepare($sql);

require_once(__DIR__ . '/components/header.php');

// HAS TO CHECK FOR SESSION IN ORDER TO ADD TO CART HERE?

?>

<main class="shop">
    <section class="section-one grid mb-small">
        <div class="container-banner mb-medium p-small ph-xlarge bg-dark-brown">
            <div class="content-container grid grid-two relative">
                <div class="container-header align-items-center color-white">
                    <h1>COFFEE FOR EVERY OCCASION</h1>
                    <h2 class="banner-message mt-small">
                        Choose From Our Wide Collection of Quality Coffee
                    </h2>
                </div>
                <div class="image bg-contain absolute"></div>
            </div>
        </div>
        </div>

        <section class=" grid mb-large">

            <h2>Shop</h2>

            <form id="formSearch" class="grid justify-self-right pv-medium mr-medium">
                <label for="txtSearch" class="mh-small align-self-bottom">
                <input id="txtSearch" type="text" name="search" placeholder="Type here to search for products or country of origins" maxlength="50" minlength="1" autocomplete="off"></label>
                <button id="searchBtn" class="button">Search</button>

            </form>
            <div id="forSearch"></div>
            <div id="results" class="pv-small grid align-items-center"></div>

            <div class="products grid grid-two-thirds-bigger mr-medium">

                <div class="filter color-white relative">
                    <!-- <h3 class="color-black ph-medium pb-medium">Filters</h3> -->
                    <div class="filter-container">
                        <button class="accordion price bg-medium-light-brown color-white">Price</button>
                        <div class="panel filter-price bg-white color-black">
                            <div class="options">
                                <label for="price">
                                    <input name="price" type="range" min="0" max="150" id="rangePrice" value="150" step="10"><span id="priceValue"></span>
                            </div>
                        </div>

                        <button class="accordion origin bg-medium-light-brown color-white">Origin</button>
                        <div class="panel filter-origin bg-white color-black">
                            <div class="options" id="coffeeTypesdiv">

                                <label for="typeOption1" class="checkbox grid">
                                    <input type="checkbox" value="Colombia" class="align-self-center" name="typeOption1">
                                    <span>Colombia</span>
                                </label><br>
                                <label for="typeOption2" class="checkbox grid">
                                    <input type="checkbox" value="Ethiopia" class="align-self-center" id="typeOption2"> <span>Ethiopia</span>
                                </label><br>
                                <label for="typeOption3" class="checkbox grid">
                                    <input type="checkbox" value="Sumatra" class="align-self-center" id="typeOption3">
                                    <span>Sumatra</span>
                                </label><br>
                                <label for="typeOption4" class="checkbox grid">
                                    <input type="checkbox" value="Brazil" class="align-self-center" id="typeOption4">
                                    <span>Brazil</span>
                                </label><br>
                                <label for="typeOption5" class="checkbox grid">
                                    <input type="checkbox" value="Nicaragua" class="align-self-center" id="typeOption5">
                                    <span>Nicaragua</span>
                                </label><br>
                                <label for="typeOption6" class="checkbox grid">
                                    <input type="checkbox" value="Blend" class="align-self-center" id="typeOption6">
                                    <span>Blend</span>
                                </label><br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="products-container grid grid-three">
                    <?php
                    if ($statement->execute()) {

                        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $connection = null;

                        foreach ($products as $product) {

                            // if ($product['bActive'] !== 0) {

                            $imgUrl = $product['cProductName'];
                            $result = strtolower(str_replace(" ", "-", $imgUrl));

                            echo '
            <a href="singleProduct?id=' . $product['nProductID'] . '">
                <div class="product relative" id="product-' . $product['nProductID'] . '">
                    <div class="image bg-contain" style="background-image: url(img/products/' . $result . '.png)"></div>
                    <div class="description m-small">
                        <h3 class="productName mt-small text-left">' . $product['cProductName'] . '</h3>
                        <h4 class="productCoffeeType mt-small text-left">' . $product['cName'] . '</h4>
                    <h4 class="absolute productPrice mt-small">' . $product['nPrice'] . ' DKK</h4>
                    </div>
                </div>
            </a>
            ';
                        }
                    }

                    ?>
                </div>

            </div>
            <template>
                <a href="">
                    <div class="product ">
                        <div class="image bg-contain"></div>
                        <div class="description m-small">
                            <h3 class="productName mt-small text-left"></h3>
                            <h4 class="productCoffeeType mt-small text-left"></h4>
                            <h4 class="productPrice mt-small"></h4>
                        </div>

                    </div>
                </a>
            </template>
        </section>

</main>

<?php

$connection = null;

$sScriptPath = 'filter.js';
require_once(__DIR__ . '/components/footer.php');
