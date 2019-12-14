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
    <label class="grid" for="inputIBAN">
        <p class="text-left align-self-center mt-small">IBAN</p>
        <input required data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="text" data-type="string" name="inputIBAN" placeholder="IBAN (format 123456789123456789)" value="">
        <div class="errorMessage">IBAN must be 18 digits</div>
      </label>

      <label class="grid" for="inputCCV">
        <p class="text-left align-self-center mt-small">CCV</p>
        <input  data-type="integer" data-min="99" data-max="999" type="text" name="inputCCV" placeholder="CCV (format 123)" value="" required>
        <div class="errorMessage">CCV must be 3 digits</div>
      </label>

      <label class="grid" for="inputExpiration">
        <p class="text-left align-self-center mt-small">Expiration date</p>
        <input  required data-type="integer" data-min="999" data-max="9999" type="text" name="inputExpiration" placeholder="Expiration date (format mmyy)" value="">
        <div class="errorMessage">Expiration date must be 4 digits</div>
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