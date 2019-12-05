<?php
$sTitle = ' | Shop';
$sCurrentPage = 'shop';

require_once(__DIR__ . '/connection.php');
$sql = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, tProduct.nPrice, tProduct.nStock, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID";
$statement = $connection->prepare($sql);

require_once(__DIR__ . '/components/header.php');

if ($statement->execute()) {
    foreach ($connection->query($sql) as $row) {
        $sCoffeeTypeName = $row['cName'];
        $aCoffeeTypes = [];
        array_push($aCoffeeTypes, $sCoffeeTypeName);
    }

    $aPrice = [];
}

?>
<main class="shop">

    <section class="section-one grid mb-small">
        <div class="container-banner mv-medium pv-medium ph-xlarge bg-dark-brown">
            <div class="content-container grid grid-almost-two">
                <div class="grid container-header align-items-center color-white">
                    <div class="align-self-bottom mb-small">
                        <h1>COFFEE FOR EVERY OCCASION</h1>
                    </div>
                    <p class="align-self-top mt-small mb-medium">
                        Choose From Our Wide Collection of Quality Coffee
                    </p>
                </div>
                <div class="grid image bg-contain relative">
                </div>
            </div>
        </div>
    </section>

    <section class="section-two grid mb-large">

        <h2>Shop</h2>

        <form id="formSearch" class="justify-self-right p-medium" action="">
            <label for="txtSearch" class="mh-small align-self-bottom">Search</label>
            <input id="txtSearch" type="text" name="search" placeholder="Type here to search for products" maxlength="50" minlength="3">
        </form>

        <div class="products grid grid-two-thirds-bigger mr-medium">

            <div class="filter color-white relative">
                <h3 class="color-black ph-medium pb-medium">Filters</h3>

                <button class="accordion price bg-medium-light-brown color-white">Price</button>
                <div class="panel filter-price bg-white color-black">
                    <div class="options">
                        <input type="checkbox" name="option1" value="0-50">
                        < 50 DKK<br>
                            <input type="checkbox" name="option2" value="51-100"> 51-100 DKK<br>
                            <input type="checkbox" name="option3" value="101-150"> 101-150 DKK<br>
                            <input type="checkbox" name="option4" value="101-150"> 151-200 DKK<br>
                            <input type="checkbox" name="option4" value="200-10000000"> + 200 DKK<br>
                    </div>
                </div>

                <button class="accordion origin bg-medium-light-brown color-white">Origin</button>
                <div class="panel filter-origin bg-white color-black">
                    <div class="options">
                        <input type="checkbox" name="option1" value="101-150"> Colombia<br>
                        <input type="checkbox" name="option2" value="101-150"> Ethiopia<br>
                        <input type="checkbox" name="option3" value="101-150"> Sumatra<br>
                        <input type="checkbox" name="option4" value="101-150"> Brazil<br>
                        <input type="checkbox" name="option5" value="101-150"> Nicaragua<br>
                        <input type="checkbox" name="option5" value="101-150"> Blend<br>
                    </div>
                </div>
            </div>

            <div class="products-container grid grid-three">
                <?php
                if ($statement->execute()) {
                    foreach ($connection->query($sql) as $row) {

                        $imgUrl = $row['cProductName'];
                        $result = strtolower(str_replace(" ", "-", $imgUrl));

                        echo '
                        <a href="singleProduct.php?id=' . $row['nProductID'] . '">
                        <div class="product mb-medium" id="product-' . $row['nProductID'] . '">
                        <div class="image bg-contain" style="background-image: url(img/products/' . $result . '.png)"></div>
                        <div class="description m-small">
                            <h3 class="productName mt-small text-left">' . $row['cProductName'] . '</h3>
                            <h4 class="productName mt-small text-left">' . $row['cName'] . '</h4>
                            <p class="productPrice mt-small">' . $row['nPrice'] . ' DKK</p>
                        </div>
                        </div>
                        </a>
                        ';
                    }
                }
                ?>

            </div>

        </div>

    </section>
    <template>
        <a href="">
            <div class="product mb-medium">
                <div class="image bg-contain">
                    <div class="description m-small">
                        <h3 class="productName mt-small text-left"></h3>
                        <h4 class="productName mt-small text-left"></h4>
                        <p class="productPrice mt-small"></p>
                    </div>
                </div>
            </div>
        </a>
    </template>
</main>

<?php
$sScriptPath = 'filter.js';
require_once(__DIR__ . '/components/footer.php');
