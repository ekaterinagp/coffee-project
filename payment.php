<?php 
$sTitle = ' | Payment';
$sCurrentPage = 'payment';
require_once(__DIR__ . '/components/functions.php');
require_once(__DIR__.'/components/header.php');
if($_SESSION){
  $nUserID= $_SESSION['user']['nUserID'];
}
?>
  <main id="paymentMain">
    <h2>Checkout </h2>
  <div class="grid grid-two m-medium">
    <div id="paymentOverview" class="p-medium  grid grid-two">
    <img src="" />  
    <div>
    <h3 id="youSelected"> </h3>
    <h4>Total Amount to Pay:</h4>
           <h2 id="sumTopay"></h2>
           </div>
      <?php
      if(!$_SESSION){
        ?>
        <div class="mv-medium">
  
      <p>To make a purchase you need to be signed in</p>
      <a href="login.php" class="link mv-small">Go to Login</a>
      <a href="signup.php" class="link mv-small">Go to Signup</a>
      </div>
    <?php
    } ?>
    </div>
  
  <div class="hiddenPaymentForm p-medium bg-grey">
  <form method="POST">
      <h3>Payment Details</h3>
    <?php
    require_once(__DIR__ . '/connection.php');
    $sql = "SELECT * FROM tCreditCard WHERE tCreditCard.nUserID = :id";
    $statementCreditCard = $connection->prepare($sql);
  if($statementCreditCard->execute([':id' => $nUserID])){
      $userCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);
      if($userCreditCards>=1){
    ?><label for=""><p>Choose from your saved credit cards</p>
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
    <button class="button purchaseBtn ">Purchase</button>
    </form>
    <button class="button">Add New</button>
<form method="POST">
    <label class="grid" for="inputIBAN">
        <p class="text-left align-self-center mb-small">IBAN</p>
        <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="text" data-type="string" name="inputIBAN" placeholder="IBAN (format 123456789123456789)" value="">
        <div class="errorMessage">IBAN must be 18 digits</div>
      </label>

      <label class="grid" for="inputCCV">
        <p class="text-left align-self-center mb-small">CCV</p>
        <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="text" name="inputCCV" placeholder="CCV (format 123)" value="">
        <div class="errorMessage">CCV must be 3 digits</div>
      </label>

      <label class="grid" for="inputExpiration">
        <p class="text-left align-self-center mb-small">Expiration date</p>
        <input class="mb-small" data-type="integer" data-min="999" data-max="9999" type="text" name="inputExpiration" placeholder="Expiration date (format mmyy)" value="">
        <div class="errorMessage">Expiration date must be 4 digits</div>
      </label>
      <button class="button addCreditCard">Purchase</button>
    </form>
    </div>
    </div>
    
  </main>
<script src="js/payment.js"></script>
<?php
$sScriptPath = 'script.js';

require_once(__DIR__.'/components/footer.php');