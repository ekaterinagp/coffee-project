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

  require_once(__DIR__ . '/connection.php');

  $sql = "SELECT * FROM tCreditCard WHERE tCreditCard.nUserID = :id";
  $statementCreditCard = $connection->prepare($sql);
}

?>
  <main id="paymentMain" class="mv-medium">  
    <a href="cart" class=" back-button color-orange absolute">&lt;</a>
    <h1 class=" text-center">Checkout </h1>
  <div class="grid grid-two  m-medium">
    <div id="paymentOverview" class="p-medium  grid grid-two">
    <img src="" />  
    <div class="mt-medium">
    <h3 id="youSelected"> </h3>
    <h4>Total Amount to Pay:</h4>
           <h2 id="sumTopay"></h2>
           </div>
     
    </div>
  
  <div class="paymentForm p-medium bg-grey">
    <h2>Payment Details</h2>
  <form method="POST" id="savedCardFrm" class="choose-credit-card mb-medium grid grid-two-thirds-reversed">
<?php

if($statementCreditCard->execute([':id' => $nUserID])){
      $userCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);
      $connection = null;
      if($userCreditCards>=1){?>
      <label><p class="text-left align-self-center mt-small">Your saved credit cards</p>
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
    <button class="button purchaseBtn align-self-bottom">Purchase</button>
    </form><h4>Or pay with another credit card</h4>
    <button class="button show-newCardFrm">Add New</button>
<form method="POST" id="newCardFrm">
<label class="grid grid-two-thirds" for="inputIBAN">
            <p class="text-left align-self-center">IBAN</p><h5 class="light">IBAN must be 18 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="number" data-type="string" name="inputIBAN" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputCCV">
            <p class="text-left align-self-center">CCV</p><h5 class="light">CCV must be 3 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="number" name="inputCCV" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputExpiration">
            <p class="text-left align-self-center">Expiration date</p> <h5 class="light">Expiration date must be 4 digits</h5>
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