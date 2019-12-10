<?php

require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/functions.php');

if(!$_SESSION){
  header('Location: login.php');
  exit;
}

if(isset($jUserSubscription['dDeleteUser'])){
  header('Location: login.php');
  exit;
}

if($_SESSION){

$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];

$sTitle = ' | Your profile'; 
$sCurrentPage = 'Profile';

$sqlProducts = "SELECT tProduct.nProductID, tProduct.cName as cProductName, tProduct.nCoffeeTypeID as nProductCoffeeTypeID, tProduct.nPrice, tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID";
$statementProducts = $connection->prepare($sqlProducts);

$sqlSubscriptions =  "SELECT tsubscriptiontype.cName, tproduct.cName as cProductName, tsubscriptiontype.nSubscriptionTypeID as nSubscriptionID, tProduct.nPrice as nSubscriptionPrice, tProduct.bActive FROM tsubscriptiontype INNER JOIN tproduct on tproduct.nProductID=tsubscriptiontype.nProductID";
$statementSubscriptions = $connection->prepare($sqlSubscriptions);

$sqlUserSubscription = "SELECT tUserSubscription.nUserSubscriptionID, tUserSubscription.dCancellation, tSubscriptionType.nSubscriptionTypeID, 
tProduct.nProductID, tProduct.cName as cProductName, tProduct.nPrice, tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName  
FROM tUser
INNER JOIN tUserSubscription ON tUser.nUserID = tUserSubscription.nUserID 
INNER JOIN tSubscriptionType ON tUserSubscription.nSubscriptionTypeID = tSubscriptionType.nSubscriptionTypeID 
INNER JOIN tProduct ON tSubscriptionType.nProductID = tProduct.nProductID 
INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID WHERE tuser.nUserID = :id";
$statementUserSubscription = $connection->prepare($sqlUserSubscription);

$sqlCreditCard = "SELECT * FROM tCreditCard WHERE tCreditCard.nUserID = :id";
$statementCreditCard = $connection->prepare($sqlCreditCard);

?>

<main class="profile">
  <button class="button log-out">Logout</button>
<h1 class="text-center">Welcome <?= $jLoggedUser['cName'];?></h1>
<button class="button delete-profile-button">Delete Profile</button>
<section class="section-one grid grid-two mb-large ph-large pt-medium">

<div>
  <div class="profile-details bg-dark-brown p-medium">
    <h2 class="color-white">Profile Details</h2>
    <form id="form-profile" method="post">
      <label id="cName" class="grid grid-two-thirds-reversed" for="name"><p class="text-left align-self-center mb-small">Name</p>
        <input class="mb-small" minlength="2" maxlength="20" type="text" data-type="string" name="inputName" placeholder="First name" value="<?= $jLoggedUser['cName'];?>">
        <div class="errorMessage">Name must be more than 1 and less than 20 letters</div>
        <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>

      <label id="cSurname" class="grid grid-two-thirds-reversed" for="lastName"><p class="text-left align-self-center mb-small">Last Name</p>
        <input class="mb-small" data-type="string" minlength="2" maxlength="20" type="text" name="inputLastName" placeholder="Last name" value="<?= $jLoggedUser['cSurname'];?>">
        <div class="errorMessage">Last name must be more than 1 and less than 20 letters</div>
        <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>

      <label id="cEmail" class="grid grid-two-thirds-reversed" for="email"><p class="text-left align-self-center mb-small">Email</p>
        <input class="mb-small" type="email" data-type="email" name="inputEmail" placeholder="email" value="<?= $jLoggedUser['cEmail'];?>">
        <div class="errorMessage" id="emailDiv">Must be a valid email address</div>
        <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>
      <label id="nCityID" for="cityInput" class="grid grid-two-thirds-reversed"><p class="text-left align-self-center mb-small">City</p>
        <select class="mb-small" name="cityInput" value="<?= $jLoggedUser['nCityID']?>">
            <option value="1" <?php if($jLoggedUser['nCityID']=1) echo 'selected'?>>Copenhagen</option>
            <option value="2"<?php if($jLoggedUser['nCityID']=2) echo 'selected'?>>Århus</option>
            <option value="3" <?php if($jLoggedUser['nCityID']=3) echo 'selected'?>>Odense</option>
            <option value="4" <?php if($jLoggedUser['nCityID']=4) echo 'selected'?>>Roskilde</option>
            <option value="5" <?php if($jLoggedUser['nCityID']=5) echo 'selected'?>>Lyngby</option>
            <option value="6" <?php if($jLoggedUser['nCityID']=6) echo 'selected'?>>Aalborg</option>
            <option value="7" <?php if($jLoggedUser['nCityID']=7) echo 'selected'?>>Silkeborg</option>
            <option value="8" <?php if($jLoggedUser['nCityID']=8) echo 'selected'?>>Ballerup</option>
            <option value="9" <?php if($jLoggedUser['nCityID']=9) echo 'selected'?>>Hellerup</option>
            <option value="10" <?php if($jLoggedUser['nCityID']=10) echo 'selected'?>>Holte</option>
            <option value="11" <?php if($jLoggedUser['nCityID']=11) echo 'selected'?>>Horsens</option>
            <option value="12" <?php if($jLoggedUser['nCityID']=12) echo 'selected'?>>Randers</option>
            <option value="13" <?php if($jLoggedUser['nCityID']=13) echo 'selected'?>>Sønderborg</option>
            <option value="14" <?php if($jLoggedUser['nCityID']=14) echo 'selected'?>>Helsingør</option>
            <option value="15" <?php if($jLoggedUser['nCityID']=15) echo 'selected'?>>Dragør</option>
            <option value="16" <?php if($jLoggedUser['nCityID']=16) echo 'selected'?>>Charlottenlund</option>
            <option value="17" <?php if($jLoggedUser['nCityID']=17) echo 'selected'?>>Frederiksberg</option>
            <option value="18" <?php if($jLoggedUser['nCityID']=18) echo 'selected'?>>Valby</option>
            <option value="19" <?php if($jLoggedUser['nCityID']=19) echo 'selected'?>>Whateverby</option>
            <option value="20" <?php if($jLoggedUser['nCityID']=20) echo 'selected'?>>Herlev</option>
            <option value="21" <?php if($jLoggedUser['nCityID']=21) echo 'selected'?>>Vanløse</option>
          </select>
          <button class="button-edit m-small button">Edit</button>
          <button class="button-save hide-button m-small button">Save</button>
        </label>
      <label id="cAddress" class="grid grid-two-thirds-reversed" for="userAddress"><p class="text-left align-self-center mb-small">Address</p>
        <input class="mb-small" type="text" data-type="string" name="inputAddress" placeholder="Address" value="<?= $jLoggedUser['cAddress'];?>">
        <div class="errorMessage">Must be more than 12 characters</div>
        <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>

      <label id="cPhoneNo" class="grid grid-two-thirds-reversed" for="userPhone"><p class="text-left align-self-center mb-small">Phone</p>
        <input class="mb-small" type="text" data-type="string" name="inputPhone" placeholder="phone number" value="<?= $jLoggedUser['cPhoneNo'];?>">
        <div class="errorMessage">Must be 8 characters</div>
        <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>

      <label class="grid grid-two-thirds-reversed" for="loginName"><p class="text-left align-self-center mb-small">Username</p>
        <input class="mb-small" type="text" data-type="string" name="inputLoginName" placeholder="username" value="<?= $jLoggedUser['cUsername'];?>">
          <div class="errorMessage">Must be more than 2 and less than 12</div>
          <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
        </label>

      <label class="grid grid-two-thirds-reversed" for="password"><p class="text-left align-self-center mb-small">Password</p>
        <input class="mb-small" type="password" data-type="string" minlength="8" maxlength="8" name="password" placeholder="password">
          <div class="errorMessage">Password must be 8 characters</div>
          <button class="button-edit ml-small button">Edit</button>
        <button class="button-save hide-button ml-small button">Save</button>
      </label>
    </form>
  </div>
  </div>
  <div class="profile-details creditcard-info bg-light-brown p-medium">
    <h2 class="color-white">Creditcard Details</h2>
    
    <?php 

if($statementCreditCard->execute([':id' => $nUserID])){
  $jUserCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);

  if(count($jUserCreditCards)>=1){

    
    foreach($jUserCreditCards as $jUserCreditCard){
      
      if(!isset($jUserCreditCard['dDeleteCreditCard'])){
      $nCreditCardID = $jUserCreditCard['nCreditCardID'];
    ;?>
    <div id="creditcard-<?=$nCreditCardID;?>" class="mb-medium mt-small">
        <div class="description">
          <div class="creditcard-details">
            <h3 class="color-white">IBAN</h3>
            <p class="mv-small text-left color-white"><?=$jUserCreditCard['cIBAN'];?></p>
            <h3 class="color-white">Expiration</h3>
            <p class="mv-small text-left color-white"><?=$jUserCreditCard['cExpiration'];?></p>
          </div>
        </div>
        <button class="button-delete-card button">Delete</button>
      </div>
      
      <?php   
    }
  }
}
};?>
  <h2 class="color-white">Add creditcard</h2>
    <form id="form-creditcard" method="post" class="mt-small">

      <label class="grid" for="inputIBAN"><p class="text-left align-self-center mb-small">IBAN</p>
        <input class="mb-small" minlength="18" maxlength="18" type="text" data-type="string" name="inputIBAN" placeholder="IBAN (format 123456789123456789)" value="">
        <div class="errorMessage">IBAN must be 18 digits</div>
      </label>

      <label class="grid" for="inputCCV"><p class="text-left align-self-center mb-small">CCV</p>
        <input class="mb-small" data-type="string" minlength="3" maxlength="3" type="text" name="inputCCV" placeholder="CCV (format 123)" value="">
        <div class="errorMessage">CCV must be 3 digits</div>
      </label>

      <label class="grid" for="inputExpiration"><p class="text-left align-self-center mb-small">Expiration date</p>
        <input class="mb-small" data-type="string" minlength="4" maxlength="4" type="text" name="inputExpiration" placeholder="Expiration date (format mmyy)" value="">
        <div class="errorMessage">Expiration date must be 4 digits</div>
      </label>

      <button class="button-add button">Add creditcard</button>
      <button class="button-save hide-button button">Save creditcard</button>
    </form>
  </div>
</section>


<section class="section-two mb-large ph-medium pt-medium current-subscription">
  <h2 class=" text-left mb-medium">Your current subscriptions</h2> 
  <div class="current-subscriptions grid grid-two">

<?php 
if($statementUserSubscription->execute([':id' => $nUserID])){
  $jUserSubscriptions = $statementUserSubscription->fetchAll(PDO::FETCH_ASSOC);

  if(count($jUserSubscriptions)>=1){
    $arrayProductID = [];
    $arrayCoffeeTypeID = [];
    $arraySubscriptionTypeID = [];

    foreach($jUserSubscriptions as $jUserSubscription){

      if(!isset($jUserSubscription['dCancellation'])){
        echo $jUserSubscription['dCancellation'];
          
        if($jUserSubscription['bActive']!==0){

          $nProductID = $jUserSubscription['nProductID'];
          array_push($arrayProductID, $nProductID);

          $nCoffeeTypeID = $jUserSubscription['nCoffeeTypeID'];
          array_push($arrayCoffeeTypeID, $nCoffeeTypeID);

          $nSubscriptionTypeID = $jUserSubscription['nSubscriptionTypeID'];
          array_push($arraySubscriptionTypeID, $nSubscriptionTypeID);
          
          $imgUrl = $jUserSubscription['cProductName'];
          $result = strtolower(str_replace(" ", "-", $imgUrl));
;?>
    <div id="subscription-<?=$jUserSubscription['nUserSubscriptionID'];?>" class="product-info-container grid grid-two">
      <div class="image bg-contain" style="background-image: url('img/products/<?= $result;?>.png')"></div>
      <div class="description mh-small mv-medium grid grid-two">
        <div class="product-details">
          <h1 class="productName mv-small text-left"><?=$jUserSubscription['cProductName'];?></h1>
          <h2 class="coffee-type mv-small text-left light"><?=$jUserSubscription['cName'];?></h2>
          <p class="productPrice mv-small"><?=$jUserSubscription['nPrice'];?> DKK</p>
         </div>
        </div>
      <button class="button-delete button">Delete</button>
    </div>

<?php
        }
      }
    }
  }
}
?>
 </div>
</section>

<section class="section-three mb-large ph-large pt-medium">
  <h2>Want to try something new</h2>
  <div class="related-products relative">
  <h2 class="coffee-type text-left mb-medium">Products</h2>
  <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
  <div class="products-container grid grid-four"> 

<?php

if($statementProducts->execute()){

  $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);
  $arrayRelatedProducts = [];

  foreach($jProducts as $jProduct){

    if($jProduct['bActive']!==0){

    $nRelatedProductCoffeeTypeID = $jProduct['nCoffeeTypeID'];
    $nRelatedProductID = $jProduct['nProductID'];

      if(!in_array($nRelatedProductID, $arrayProductID)){

        array_push($arrayRelatedProducts, $nRelatedProductID);

        $imgUrl = $jProduct['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
?>
      <a href="singleProduct.php?id=<?=$jProduct['nProductID'];?>">
        <div class="product" id="product-<?=$jProduct['nProductID'];?>">
          <div class="image bg-contain" style="background-image: url(img/products/<?=$result;?>.png)"></div>
          <div class="description m-small">
            <h3 class="productName mt-small text-left"><?=$jProduct['cProductName'];?></h3>
            <h4 class="productName mt-small text-left">Origin: <?=$jProduct['cName'];?></h4>
            <p class="productPrice mt-small"><?=$jProduct['nPrice'];?> DKK</p>
          </div>
        </div>
      </a>
<?php

        }
      }
       if(count($arrayRelatedProducts) > 3){
        break;
      }
    }
  }

;?>
  </div>
  </div>

  <div class="related-subscriptions relative">

  <h2 class="coffee-type text-left mb-medium pt-medium">Subscriptions</h2>
  <div class="container-banner absolute pv-large bg-dark-brown"></div>
  <div class="containerForSubscriptions grid grid-three m-medium">

<?php
  
  if($statementSubscriptions->execute()){
    $jSubscriptions = $statementSubscriptions->fetchAll(PDO::FETCH_ASSOC);
    $arrayRelatedSubscriptionID = [];

    foreach($jSubscriptions as $jSubscription){

      if($jSubscription['bActive']!==0){

        $nRelatedSubscriptionID = $jSubscription['nSubscriptionID'];

          if(!in_array($nRelatedSubscriptionID, $arraySubscriptionTypeID)){

            array_push($arrayRelatedSubscriptionID, $nRelatedSubscriptionID);

            $imgUrl = $jSubscription['cProductName'];
            $result = strtolower(str_replace(" ", "-", $imgUrl));
?>

<div class="subscriptionItem" id="<?= $jSubscription['nSubscriptionTypeID'] ;?>">
          <div class="subscriptionItemBg">
            <h4 class="subscribeOptiopnP">Option</4>
            <h1 class="subscribeTypeNumber"><?= $jSubscription['nSubscriptionID'] ?></h1>
            <img src="img/products/<?= $result ;?>.png" alt="">  
            <h2><?= $jSubscription['cName'];?></h2>
          </div>
        <div class="white-text-bg">
          <p class="descSubscription">Lorem ipsum dolor sit amet consectetur 
          adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis
          quasi provident nulla minus odit architecto.</p>
          <h3 class="priceSubscription"><?= $jSubscription['nSubscriptionPrice'] ;?> DKK</h3>
          </div>
          <a href=""><button class="paymentButton button">To Payment</button></a>
        </div>
<?php
          
        }
      }
        if(count($arrayRelatedSubscriptionID) > 2){
        break;
        }
    }
  }
}
;?>
</div>
    </div>
  </section>
</main>

<?php
$sScriptPath = 'profile.js';
require_once(__DIR__ . '/components/footer.php');
