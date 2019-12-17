<?php
$sTitle = ' | Your cart';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
?>

<main class="cartMain mt-small mb-footer">
<h1 class="text-center">Your cart</h1>
  <div class="cartTotal mh-medium">
    <section id="cartItems">
      
      <template id="cartItemTemplate">
        <div id="" class="cartDiv grid  mb-small ">
          <p class="bold">Description</p>
          <p class="bold">Price</p>
          <p class="bold">Quantity</p>
      <div class="frmLine"></div>
          <div >
            <h3 class="title_cart bold uppercase pl-small" name="coffeeName"></h3>
            <input class="type_cart_grind " name="coffeeGrind">
          <img class="img_cart align-self-center" src="" />
          </div>

            <!-- <div class="price_number"> -->
              <input class=" price_cart " name="coffeePrice">
              <input class="cart_quantity " name="coffeeQuantity">

            <button class="remove button align-self-center">Remove item</button>
          <!-- </div> -->
        </div>
      </template>

    </section>

    <div class="total bg-grey ml-medium p-medium align-self-top">
     
      <section id="totalItemsSection">
        
        <template id="totalItemsTemplate">
          
          <!-- <h3 id="" class="totalDiv">
           
          </h3> -->
        </template>
      </section>
      <h3 class="align-self-bottom mt-medium text-right">Total amount</h3>
      <h4 id="totalsum" class="pb-small text-right align-self-top"></h4>
      <h3 class="align-self-bottom text-right">Tax</h3>
      <h4 id="tax" class="pb-small text-right align-self-top"></h4>
      <a href="<?php if($_SESSION){echo 'payment';} else{echo'log-in';}?>"><button class="button margin-auto mv-small paymentButton"><?php if($_SESSION){echo 'Go to payment';} else{echo'Please log in';}?></button></a>
    
  </div>
  </div>
  <div class="noCart">
    <h3 class="mt-medium text-center"> Your cart seems to be empty...</h3>

    <section class="section-three ph-large pt-medium">
      <div class="related-products relative">
        <h2 class="coffee-type mb-medium">Discover a world of quality coffee</h2>
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
