<?php
$sTitle = ' | Your cart';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/header.php');


?>

<main>

<?php


?>

  <div class="cartTotal mv-medium mh-large">
    <section id="cartItems">
      <template id="cartItemTemplate">
        <div id="" class="cartDiv">
          <img class="img_cart" src="" />
          <div class="cart_desc">
            <input class="title_cart" name="coffeeName">

            <input class="type_cart_grind" name="coffeeGrind"></p>

            <div class="price_number">
              <input class="price_cart" name="coffeePrice">
              <p class="quantity"></p>
            </div>

            <div class="remove button">Remove item</div>
          </div>
        </div>
      </template>

    </section>

    <div class="total">
      <p class="">Your cart</p>
      <section id="totalItemsSection">
        
        <template id="totalItemsTemplate">
          <div id="" class="totalDiv">
            <!-- <p class="totalItemsName"></p> -->
          </div>
        </template>
      </section>
      <div id="totalsum"></div>
      <a href="payment"><button class="button" <?php if(!$_SESSION) echo'disabled';?>>Go to Payment</button></a>
      <?php
      if(!$_SESSION){
        ?>
        <div class="mv-medium">
  
      <p>To make a purchase you need to be signed in</p>
      <a href="log-in" class="link mv-small">Go to Login</a>
      <a href="sign-up" class="link mv-small">Go to Signup</a>
      </div>
    <?php
    } ?>
  </div>
</main>

<?php
$sScriptPath = 'cart.js';
require_once(__DIR__ . '/components/footer.php');
