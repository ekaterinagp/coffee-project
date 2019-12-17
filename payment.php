<?php 
$sTitle = ' | Payment';
$sCurrentPage = 'cart';
require_once(__DIR__ . '/components/functions.php');
require_once(__DIR__.'/components/header.php');

if(!$_SESSION){
  header('Location: cart');
  exit;
}

if($_SESSION){
  $nUserID= $_SESSION['user']['nUserID'];
  $userName = $_SESSION['user']['cName'];
  $userLastname = $_SESSION['user']['cSurname'];
  $userAddress = $_SESSION['user']['cAddress'];
  $userPhone = $_SESSION['user']['cPhoneNo'];
  $userCity = $_SESSION['user']['nCityID'];
  require_once(__DIR__ . '/connection.php');

  $sql = "SELECT * FROM tCreditCard WHERE tCreditCard.nUserID = :id";
  $statementCreditCard = $connection->prepare($sql);
}

?>
  <main id="paymentMain" class="mv-medium payment">  
    <a href="cart" class=" back-button absolute">&lt;</a>
    <div class="payment-container grid grid-two-thirds-reversed m-medium">
      <div>  
        <h1 class="align-self-bottom mb-small">Your purchase</h1>
        <div id="paymentOverview" class="grid p-medium">
        <p class="bold">Description</p>
        <p class="bold">Price</p>
        <p class="bold">Quantity</p>
      <div class="frmLine"></div>
      <div>

        <h3 id="youSelected" class="bold uppercase text-center"></h3>
        <img src="" /> 
      </div>
      <p class="price" name="coffeePrice"> </p>
      <p class="quantity" name="coffeePrice"> </p>
      
      </div>
    </div>
  
  <div class="paymentForm p-medium bg-grey">
      <h2 class=" text-center">Checkout </h2>
     <div class="grid grid-two">
       <div>

         <h4 class="bold mt-small">Shipping Details</h4>
         <div class="shipping pb-small">
         <p>Name</p>
         <p class=" pb-small"><?="$userName  $userLastname"?></p>
         </div>
         <div class="shipping pb-small">
         <p>Address </p>
         <p class="pb-small"><?=$userAddress?></p>
         </div>
         <div class="shipping pb-small">
         <p>City</p>
         <p class="pb-small">
            <?php if ($userCity = 1) {?>
              Copenhagen 
            <?php }
            elseif ($userCity = 2){?>
              Århus
            <?php }
            elseif ($userCity = 3){?>
              Odense
            <?php }
            elseif ($userCity = 4){?>
              Roskilde
            <?php }
            elseif ($userCity = 5){?>
              Lyngby
            <?php }
            elseif ($userCity = 6){?>
              Aalborg
            <?php }
            elseif ($userCity = 7){?>
              Silkeborg
            <?php }
            elseif ($userCity = 8){?>
              Ballerup
            <?php }
            elseif ($userCity = 9){?>
              Hellerup
            <?php }
            elseif ($userCity = 10){?>
              Holte
            <?php }
            elseif ($userCity = 11){?>
              Horsens
            <?php }
            elseif ($userCity = 12){?>
              Randers
            <?php }
            elseif ($userCity = 13){?>
              Sønderborg
            <?php }
            elseif ($userCity = 14){?>
              Helsingør
            <?php }
            elseif ($userCity = 15){?>
              Dragør
            <?php }
            elseif ($userCity = 16){?>
              Charlottenlund
            <?php }
            elseif ($userCity = 17){?>
              Frederiksberg
            <?php }
            elseif ($userCity = 18){?>
              Valby
            <?php }
            elseif ($userCity = 19){?>
              Whateverby
            <?php }
            elseif ($userCity = 20){?>
              Herlev
            <?php }
            elseif ($userCity = 21){?>
              Vanløse
            <?php }?>
        </p>
         </div>
         <div class="shipping pb-small">
         <p>Phone number </p>
         <p class="pb-medium"><?=$userPhone?></p>
         </div>
        </div>
        <div class="align-self-bottom">
        <h3 class="align-self-bottom mt-small text-right uppercase">Total amount</h3>
      <h4 class="totalPrice align-self-top" id="sumTopay"></h4>
        </div>
      </div>
  <form method="POST" id="savedCardFrm" class="choose-credit-card pb-medium grid grid-two-thirds-reversed">
<?php

if($statementCreditCard->execute([':id' => $nUserID])){
      $userCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);
      $connection = null;
      if($userCreditCards>=1){?>
      <label><p class="text-left align-self-center mb-small mt-small">Choose credit card</p>
      <select name="userCreditCards" id="">
      <?php
      foreach($userCreditCards as $userCreditCard){
      if(!isset($userCreditCard['dDeleteCreditCard'])){

        echo '<option value="'.$userCreditCard['nCreditCardID'].'">'.$userCreditCard['cIBAN'].'</option>';
      }
    }
  }
}
      ?>
    </select>
    </label>
    <button class="button show-newCardFrm">Add New</button>
    </form>
    <button class="button purchaseBtn align-self-bottom  margin-auto">Purchase</button>
<form method="POST" id="newCardFrm">
<label class="grid grid-two-thirds" for="inputIBAN">
            <p class="text-left align-self-center">IBAN</p><h5 class="light text-right">IBAN must be 18 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="number" data-type="string" name="inputIBAN" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputCCV">
            <p class="text-left align-self-center">CCV</p><h5 class="light text-right">CCV must be 3 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="number" name="inputCCV" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputExpiration">
            <p class="text-left align-self-center">Expiration date</p> <h5 class="light text-right">Expiration date must be 4 digits</h5>
            <input class="mb-small" data-type="integer" data-min="100" data-max="1999" type="number" name="inputExpiration" value="">
            
          </label>
      <button disabled class="button formBtn addCreditCard">Purchase</button>
    </form>
    
    </div>
    </div>
    

  </main>
<script src="js/payment.js"></script>
<?php
$sScriptPath = 'validation.js';

require_once(__DIR__.'/components/footer.php');