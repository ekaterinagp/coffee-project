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

$sqlSubscriptions =  "SELECT tsubscriptiontype.cName, tproduct.cName as cProductName, tsubscriptiontype.nSubscriptionTypeID as nSubscriptionID, tProduct.nPrice as nSubscriptionPrice FROM tsubscriptiontype INNER JOIN tproduct on tproduct.nProductID=tsubscriptiontype.nProductID";
$statementSubscriptions = $connection->prepare($sqlSubscriptions);

$sqlUserSubscription = "SELECT tUserSubscription.nUserSubscriptionID, tSubscriptionType.nSubscriptionTypeID, 
tProduct.nProductID, tProduct.cName as cProductName, tProduct.nPrice, tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName  
FROM tUser
INNER JOIN tUserSubscription ON tUser.nUserID = tUserSubscription.nUserID 
INNER JOIN tSubscriptionType ON tUserSubscription.nSubscriptionTypeID = tSubscriptionType.nSubscriptionTypeID 
INNER JOIN tProduct ON tSubscriptionType.nProductID = tProduct.nProductID 
INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID WHERE tuser.nUserID = :id";
$statementUserSubscription = $connection->prepare($sqlUserSubscription);

?>

<main class="profile">
<section class="section-one grid grid-two mb-large ph-large pt-medium">

  <h1>Welcome <?= $jLoggedUser['cName'];?></h1>
  <div class="profile-details bg-medium-light-brown p-medium">
    <form id="form-profile" method="post">
      <label id="cName" class="grid grid-one-fourth" for="name"><h3 class="text-left align-self-center">Name</h3>
        <input class="m-small" minlength="2" maxlength="20" type="text" data-type="string" name="inputName" placeholder="First name" value="<?= $jLoggedUser['cName'];?>">
        <div class="errorMessage">Name must be more than 1 and less than 20 letters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cSurname" class="grid grid-one-fourth" for="lastName"><h3 class="text-left align-self-center">Last Name</h3>
        <input class="m-small" data-type="string" minlength="2" maxlength="20" type="text" name="inputLastName" placeholder="Last name" value="<?= $jLoggedUser['cSurname'];?>">
        <div class="errorMessage">Last name must be more than 1 and less than 20 letters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cEmail" class="grid grid-one-fourth" for="email"><h3 class="text-left align-self-center">Email</h3>
        <input class="m-small" type="email" data-type="email" name="inputEmail" placeholder="email" value="<?= $jLoggedUser['cEmail'];?>">
        <div class="errorMessage" id="emailDiv">Must be a valid email address</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>
      <label id="nCityID" for="cityInput" class="grid grid-one-fourth"><h3 class="text-left align-self-center">City</h3> <?= $jLoggedUser['nCityID'];?>
        <select class="m-small" name="cityInput">
            <option disabled selected value> -- select your city -- </option>
            <option value="1">Copenhagen</option>
            <option value="2">Århus</option>
            <option value="3">Odense</option>
            <option value="4">Roskilde</option>
            <option value="5">Lyngby</option>
            <option value="6">Aalborg</option>
            <option value="7">Silkeborg</option>
            <option value="8">Ballerup</option>
            <option value="9">Hellerup</option>
            <option value="10">Holte</option>
            <option value="11">Horsens</option>
            <option value="12">Randers</option>
            <option value="13">Sønderborg</option>
            <option value="14">Helsingør</option>
            <option value="15">Dragør</option>
            <option value="16">Charlottenlund</option>
            <option value="17">Frederiksberg</option>
            <option value="18">Valby</option>
            <option value="19">Whateverby</option>
            <option value="20">Herlev</option>
            <option value="21">Vanløse</option>
          </select>
          <button class="button-edit button">Edit</button>
          <button class="button-save hide-button button">Save</button>
        </label>
      <label id="cAddress" class="grid grid-one-fourth" for="userAddress"><h3 class="text-left align-self-center">Address</h3>
        <input class="m-small" type="text" data-type="string" name="inputAddress" placeholder="Address" value="<?= $jLoggedUser['cAddress'];?>">
        <div class="errorMessage">Must be more than 12 characters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cPhoneNo" class="grid grid-one-fourth" for="userPhone"><h3 class="text-left align-self-center">Phone</h3>
        <input class="m-small" type="text" data-type="string" name="inputPhone" placeholder="phone number" value="<?= $jLoggedUser['cPhoneNo'];?>">
        <div class="errorMessage">Must be 8 characters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <!-- <label class="grid grid-one-fourth" for="loginName"><h3 class="text-left align-self-center">Username</h3>
        <input type="text" data-type="string" name="inputLoginName" placeholder="username" value="<?= $jLoggedUser['cUsername'];?>">
          <div class="errorMessage">Must be more than 2 and less than 12</div>
          <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
        </label>

      <label class="grid grid-one-fourth" for="password"><h3 class="text-left align-self-center">Password</h3>
        <input type="password" data-type="string" minlength="8" maxlength="8" name="password" placeholder="password">
          <div class="errorMessage">Password must be 8 characters</div>
          <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label> -->
    </form>
  </div>
</section>

<section class="section-two grid grid-two mb-large ph-medium pt-medium current-subscription">
  <div class="current-subscriptions">
    <h2 class="text-left">Your current subscriptions</h2>

<?php 
if($statementUserSubscription->execute([':id' => 24])){
  $jUserSubscriptions = $statementUserSubscription->fetchAll(PDO::FETCH_ASSOC);

  if(count($jUserSubscriptions)>=1){

    foreach($jUserSubscriptions as $jUserSubscription){

      if(!isset($jUserSubscription['dCancellation'])){
          
        if($jUserSubscription['bActive']!==0){

          $nProductID = $jUserSubscription['nProductID'];
          $arrayProductID = [];
          array_push($arrayProductID, $nProductID);

          $nCoffeeTypeID = $jUserSubscription['nCoffeeTypeID'];
          $arrayCoffeeTypeID = [];
          array_push($arrayCoffeeTypeID, $nCoffeeTypeID);

          $nSubscriptionTypeID = $jUserSubscription['nSubscriptionTypeID'];
          $arraySubscriptionTypeID = [];
          array_push($arraySubscriptionTypeID, $nSubscriptionTypeID);
          
          $imgUrl = $jUserSubscription['cProductName'];
          $result = strtolower(str_replace(" ", "-", $imgUrl));
;?>
    <div id="subscription-<?=$jUserSubscription['nUserSubscriptionID'];?>" class="product-info-container grid grid-two-thirds ml-medium">
      <div class="image bg-contain" style="background-image: url('img/products/<?= $result;?>.png')"></div>
      <div class="description mh-small mv-medium grid grid-two">
        <div>
          <h1 class="productName mv-small text-left"><?=$jUserSubscription['cProductName'];?></h1>
          <h2 class="coffee-type mv-small text-left light"><?=$jUserSubscription['cName'];?></h2>
          <p class="productPrice mv-small"><?=$jUserSubscription['nPrice'];?> DKK</p>
          <p>A soft, velvety body highlights a soft citric acidity and pleasant sweetness, with notes of raspberry, orange and sugar cane.</p>
        </div>
        <div class="mv-small">
          <h4 class="uppercase bold">Roast level</h4>
          <h3 class="uppercase light mb-small">MEDIUM ROAST</h3>
          <h4 class="uppercase bold">Type</h4>
          <h3 class="uppercase light mb-small"><?=$jUserSubscription['cName'];?></h3>
          <h4 class="uppercase bold">Recommmended for</h4>
          <h3 class="uppercase light">ESPRESSO</h3>
          <h3 class="uppercase light">FRENCH PRESS</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="current-subscription-details"></div>

<?php
        }
      }
    }
  }
}
?>
</section>

<section class="section-three mb-large ph-large pt-medium">
  <h2>Want to try something new</h2>

  <h2 class="coffee-type text-left mb-medium">Products</h2>
  <div class="container-banner absolute pv-large bg-dark-brown"></div>
  <div class="products-container grid grid-four"> 

<?php

if($statementProducts->execute()){

  $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);

  foreach($jProducts as $jProduct){

    if($jProduct['bActive']!==0){

    $nRelatedProductCoffeeTypeID = $jProduct['nCoffeeTypeID'];
    
    $nRelatedProductID = $jProduct['nProductID'];
    // echo json_encode($arrayProductID);

      if(!in_array($nRelatedProductID, $arrayProductID)){
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
    }
  }

;?>

    </div>
  </section>


  <section class="section-three mb-large ph-large pt-medium">
  <h2>Want to try something new</h2>
  <h2 class="coffee-type text-left mb-medium">Products</h2>
  <div class="container-banner absolute pv-large bg-dark-brown"></div>
  <div class="containerForSubscriptions grid grid-three m-medium">

<?php
  
  if($statementSubscriptions->execute()){
    $jSubscriptions = $statementSubscriptions->fetchAll(PDO::FETCH_ASSOC);
    foreach($jSubscriptions as $jSubscription){

      // echo json_encode($jSubscription);
      $imgUrl = $jSubscription['cProductName'];
      $result = strtolower(str_replace(" ", "-", $imgUrl));
;?>

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
}
;?>

    </div>
  </section>
</main>

<?php
$sScriptPath = 'profile.js';
require_once(__DIR__ . '/components/footer.php');

// GETS ALL PRODUCTS...
