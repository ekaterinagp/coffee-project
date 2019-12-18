<?php
$sTitle = ' | Your cart';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="cartMain mt-small mb-footer">
  <h1 class="text-left pb-small">Your cart</h1>
  <div class="cartTotal grid grid-two-thirds-reversed m-medium">
    <div>

      <section id="cartItems">
        <template id="cartItemTemplate">
          <div id="" class="cartDiv grid mb-small ">
            <p class="bold">Description</p>
            <p class="bold">Price</p>
            <p class="bold">Quantity</p>
            <div class="frmLine"></div>
            <div class="grid grid-one">
              <h3 class="title_cart bold uppercase pl-small" name="coffeeName"></h3>
              <p class="type_cart_grind"></p>
              <img class="img_cart align-self-center justify-self-start" src="" />
            </div>
            <p class="price_cart"></p>
            <input type="number" class="cart_quantity">
            <button class="remove button align-self-center">Remove item</button>
          </div>
        </template>

      </section>
    </div>
    <div class="total bg-grey p-medium align-self-top">
      <section id="totalItemsSection">
        <h2 class="text-center pb-small">Checkout</h2>
        <template id="totalItemsTemplate">
        </template>
      </section>
      <div class="grid grid-two mt-small">
        <h4 class="align-self-bottom text-left">Subtotal</h4>
        <p id="subsum" class="text-right align-self-top"></p>
      </div>
      <div class="grid grid-two mb-small">
        <h4 class="align-self-bottom text-left">Tax</h4>
        <p id="tax" class="text-right align-self-top"></p>
      </div>
      <h3 class="align-self-bottom text-right">Total amount</h3>
      <h4 id="totalsum" class="pb-small text-right align-self-top"></h4>
      <a href="<?php if ($_SESSION) {
                  echo 'payment';
                } else {
                  echo 'log-in';
                } ?>"><button class="button margin-auto mv-small paymentButton"><?php if ($_SESSION) {
                                                                                  echo 'Go to payment';
                                                                                } else {
                                                                                  echo 'Please log in';
                                                                                } ?></button></a>

    </div>
  </div>
  <div class="noCart">
    <p class="mt-medium text-center"> Your cart seems to be empty...</p>

    <section class="section-three ph-large pt-medium">
      <div class="related-products relative">
        <h2 class="coffee-type mb-medium">Discover a world of quality coffee</h2>
        <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
        <div class="products-container grid grid-four">

          <?php
                                                                                $sqlProducts = "SELECT tproduct.nProductID, tproduct.cName AS cProductName, 
  tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
  tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
  FROM tproduct INNER JOIN tcoffeetype on tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID WHERE tproduct.bActive != 0 LIMIT 4";
                                                                                $statementProducts = $connection->prepare($sqlProducts);
                                                                                if ($statementProducts->execute()) {
                                                                                  $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);
                                                                                  foreach ($jProducts as $jProduct) {
                                                                                    $imgUrl = $jProduct['cProductName'];
                                                                                    $result = strtolower(str_replace(" ", "-", $imgUrl));
                                                                                    echo
                                                                                      ' <a href="singleProduct?id=' . $jProduct['nProductID'] . '">
    <div class="product relative " id="product-' . $jProduct['nProductID'] . '">
     <div class="image bg-contain" style="background-image: url(img/products/' . $result . '.png)"></div>
    <div class="description m-small">
    <h3 class="productName mt-small text-left">' . $jProduct['cProductName'] . '</h3>
     <h4 class="productName mt-small text-left">' . $jProduct['cName'] . '</h4>
     <h4 class="productPrice absolute mt-small">' . $jProduct['nPrice'] . ' DKK</h4>
     </div>
     </div>
         </a>';
                                                                                  }; ?>
        </div>
      </div>
    </section>
  <?php
                                                                                  $connection = null;
                                                                                }; ?>
  </div>
</main>

<?php
                                                                                $sScriptPath = 'cart.js';
                                                                                require_once(__DIR__ . '/components/footer.php');
