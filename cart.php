<?php
$sTitle = ' | Your cart';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="cartMain mt-small mb-large">
  <h1 class="text-center mb-medium">Cart</h1>
  <div class="cartTotal mh-large">
    <section id="cartItems">
      <template id="cartItemTemplate">
        <div id="" class="cartDiv grid grid-two-thirds mb-small">
          <img class="img_cart align-self-center" src="" />
          <div class="cart_desc">
            <input class="title_cart bold uppercase pv-small" name="coffeeName">
            <input class="type_cart_grind pb-small" name="coffeeGrind"></p>

            <div class="price_number">
              <input class="price_cart bold pb-small" name="coffeePrice">
              <p class="quantity"></p>
            </div>

            <button class="remove button">Remove item</button>
          </div>
        </div>
      </template>

    </section>

    <div class="total bg-grey ml-medium p-large align-self-top">
      <h2 class="text-left">Your cart</h2>
      <section id="totalItemsSection">
        
        <template id="totalItemsTemplate">
          <div id="" class="totalDiv">
          </div>
        </template>
      </section>
      <div id="totalsum" class="pv-small"></div>
      <a href="<?php if($_SESSION){echo 'payment';} else{echo'log-in';}?>"><button class="button">Go to Payment</button></a>
    
  </div>
  </div>
  <div class="noCart">
    <h3 class="mt-medium text-center"> Your cart seems to be empty...</h3>

    <section class="section-three mb-large ph-large pt-medium">
      <div class="related-products relative">
        <h2 class="coffee-type mb-medium">Discover a world of qualitfy coffee</h2>
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
             <div class="product relative " id="product-'.$jProduct['nProductID'].'">
                 <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                 <div class="description m-small">
                     <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
                     <h4 class="productName mt-small text-left">'.$jProduct['cName'].'</h4>
                     <h4 class="productPrice absolute mt-small">'.$jProduct['nPrice'].' DKK</h4>
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
