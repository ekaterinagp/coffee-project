<?php
$sTitle = ' | Your cart';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/header.php');


?>

<main class="cartPage">
  <h1 class="text-center">Cart</h1>
  <div class="cartTotal mv-medium mh-large">
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

            <div class="remove button">Remove item</div>
          </div>
        </div>
      </template>

    </section>

    <div class="total bg-grey ml-medium p-large align-self-top">
      <h2 class="text-left">Your cart</h2>
      <section id="totalItemsSection">
        
        <template id="totalItemsTemplate">
          <div id="" class="totalDiv">
            <!-- <p class="totalItemsName"></p> -->
          </div>
        </template>
      </section>
      <div id="totalsum" class="pv-small"></div>
      <a href="<?php if($_SESSION){echo 'payment';} else{echo'log-in';}?>"><button class="button">Go to Payment</button></a>
    
  </div>
  </div>
  <div class="noCart">
    <h2 class="mt-large text-center"> Your cart seems to be empty</h2>
    <a href="shop" class="link text-center m-medium">Check out our Coffee products</a>
    <a href="subscribe" class="link text-center m-medium">Check out our Subscription options</a>
  </div>
</main>

<?php
$sScriptPath = 'cart.js';
require_once(__DIR__ . '/components/footer.php');
