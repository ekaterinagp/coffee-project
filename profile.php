<?php
$sTitle = '| Profile ';
$sCurrentPage = 'profile';

require_once(__DIR__ . '/components/header.php');

if (!$_SESSION) {
  header('Location: log-in');
  exit;
}

if ($_SESSION) {

require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/functions.php');

$jLoggedUser = $_SESSION['user'];
$nUserID = $jLoggedUser['nUserID'];

  if (isset($jLoggedUser['dDeleteUser'])) {
    header('Location: log-in');
    exit;
  }

  $sqlProducts = "SELECT tproduct.nProductID, tproduct.cName AS cProductName, 
                tproduct.nCoffeeTypeID AS nProductCoffeeTypeID, tproduct.nPrice, 
                tproduct.nStock, tproduct.bActive, tcoffeetype.nCoffeeTypeID, tcoffeetype.cName 
                FROM tproduct INNER JOIN tcoffeetype on tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID WHERE tproduct.bActive != 0 LIMIT 4";
  $statementProducts = $connection->prepare($sqlProducts);

  $sqlSubscriptions = "SELECT tsubscriptiontype.nSubscriptionTypeID, tsubscriptiontype.cName AS cSubscriptionName,
                      tproduct.nProductID, tproduct.cName AS cProductName, tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
                      tcoffeetype.nCoffeeTypeID, tcoffeetype.cName  
                      FROM tsubscriptiontype 
                      INNER JOIN tproduct ON tsubscriptiontype.nProductID = tproduct.nProductID 
                      INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                      WHERE tproduct.bActive != 0 LIMIT 3";
  
  $statementSubscriptions = $connection->prepare($sqlSubscriptions);

  $sqlUserSubscription = "SELECT tusersubscription.nUserSubscriptionID, tusersubscription.dCancellation, 
                        tsubscriptiontype.nSubscriptionTypeID, tsubscriptiontype.cName AS cSubscriptionName,
                        tproduct.nProductID, tproduct.cName AS cProductName, tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
                        tcoffeetype.nCoffeeTypeID, tcoffeetype.cName  
                        FROM tUser
                        INNER JOIN tusersubscription ON tuser.nUserID = tusersubscription.nUserID 
                        INNER JOIN tsubscriptiontype ON tusersubscription.nSubscriptionTypeID = tsubscriptiontype.nSubscriptionTypeID 
                        INNER JOIN tproduct ON tsubscriptionType.nProductID = tproduct.nProductID 
                        INNER JOIN tcoffeeType ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
                        WHERE tuser.nUserID = :id AND tusersubscription.dCancellation IS NULL AND tproduct.bActive != 0";

  $statementUserSubscription = $connection->prepare($sqlUserSubscription);

  $sqlCreditCard = "SELECT * FROM tcreditcard WHERE tcreditcard.nUserID = :id AND dDeleteCreditCard IS NULL";
  $statementCreditCard = $connection->prepare($sqlCreditCard);

  ?>

  <main class="profile mb-footer">
    <section class="section-one grid ph-medium mb-large">
    <h1 class="pt-medium">Welcome <?= $jLoggedUser['cName']; ?></h1>
      <div class="profile-info-container grid grid-almost-two">
        <div class="profile-details details-one grid">
          <form id="form-profile" class="grid" method="post">

          <h2 class="text-left">Profile details</h2>
          <div class="form-profile-form-container-info grid grid-two bg-grey pv-medium ph-medium">
            <label id="cName" class="grid pb-small" for="name">
              <p class="text-left align-self-center">Name</p>
              <input class=" not-input" data-type="string" data-min="2" data-max="20" type="text" data-type="string" name="inputName" placeholder="First name" value="<?= $jLoggedUser['cName']; ?>">
              <h5 class="light">Must be 1 to 20 characters</h5>
            </label>

            <label id="cSurname" class="grid grid-two-thirds pb-small" for="lastName">
              <p class="text-left align-self-center">Last Name</p>
              <input class="  not-input" data-type="string" data-min="2" data-max="20" type="text" name="inputLastName" placeholder="Last name" value="<?= $jLoggedUser['cSurname']; ?>">
              <h5 class="light">Must be 1 to 20 characters</h5>
            </label>

            <label class="grid grid-two-thirds pb-small" for="loginName">
              <p class="text-left align-self-center">Username</p>
              <input class=" not-input" type="text" data-type="string" data-min="2" data-max="12" name="inputLoginName" placeholder="username" value="<?= $jLoggedUser['cUsername']; ?>">
              <h5 class="light">Must be 2 to 12 characters</h5>
            </label>

            <label id="cEmail" class="grid grid-two-thirds pb-small" for="email">
              <p class="text-left align-self-center">Email</p>
              <input class=" not-input" type="email" data-type="email" name="inputEmail" placeholder="email" value="<?= $jLoggedUser['cEmail']; ?>">
              <h5 class="light">Must be a valid email address</h5>
            </label>
            <div class="formButtonContainer">
                <button class="button-edit button">Edit information</button>
                <button class="button-save formBtn hide-button button">Save information</button>
            </div>
            </div>

            <h2 class="text-left">Shipping details</h2>
            <div class="form-profile-form-container-shipping grid grid-two bg-grey pv-medium ph-medium">
            <label id="nCityID" for="cityInput" class="grid pb-small">
              <p class="text-left align-self-center">City</p>
              <select class=" not-input" data-type="integer" data-min="0" data-max="999" name="cityInput" value="<?= $jLoggedUser['nCityID'] ?>">
                <option value="1" <?php if ($jLoggedUser['nCityID'] = 1) echo 'selected' ?>>Copenhagen</option>
                <option value="2" <?php if ($jLoggedUser['nCityID'] = 2) echo 'selected' ?>>Århus</option>
                <option value="3" <?php if ($jLoggedUser['nCityID'] = 3) echo 'selected' ?>>Odense</option>
                <option value="4" <?php if ($jLoggedUser['nCityID'] = 4) echo 'selected' ?>>Roskilde</option>
                <option value="5" <?php if ($jLoggedUser['nCityID'] = 5) echo 'selected' ?>>Lyngby</option>
                <option value="6" <?php if ($jLoggedUser['nCityID'] = 6) echo 'selected' ?>>Aalborg</option>
                <option value="7" <?php if ($jLoggedUser['nCityID'] = 7) echo 'selected' ?>>Silkeborg</option>
                <option value="8" <?php if ($jLoggedUser['nCityID'] = 8) echo 'selected' ?>>Ballerup</option>
                <option value="9" <?php if ($jLoggedUser['nCityID'] = 9) echo 'selected' ?>>Hellerup</option>
                <option value="10" <?php if ($jLoggedUser['nCityID'] = 10) echo 'selected' ?>>Holte</option>
                <option value="11" <?php if ($jLoggedUser['nCityID'] = 11) echo 'selected' ?>>Horsens</option>
                <option value="12" <?php if ($jLoggedUser['nCityID'] = 12) echo 'selected' ?>>Randers</option>
                <option value="13" <?php if ($jLoggedUser['nCityID'] = 13) echo 'selected' ?>>Sønderborg</option>
                <option value="14" <?php if ($jLoggedUser['nCityID'] = 14) echo 'selected' ?>>Helsingør</option>
                <option value="15" <?php if ($jLoggedUser['nCityID'] = 15) echo 'selected' ?>>Dragør</option>
                <option value="16" <?php if ($jLoggedUser['nCityID'] = 16) echo 'selected' ?>>Charlottenlund</option>
                <option value="17" <?php if ($jLoggedUser['nCityID'] = 17) echo 'selected' ?>>Frederiksberg</option>
                <option value="18" <?php if ($jLoggedUser['nCityID'] = 18) echo 'selected' ?>>Valby</option>
                <option value="19" <?php if ($jLoggedUser['nCityID'] = 19) echo 'selected' ?>>Whateverby</option>
                <option value="20" <?php if ($jLoggedUser['nCityID'] = 20) echo 'selected' ?>>Herlev</option>
                <option value="21" <?php if ($jLoggedUser['nCityID'] = 21) echo 'selected' ?>>Vanløse</option>
              </select>
              <h5 class="light">Choose your city</h5>
            </label>
            <label id="cAddress" class="grid grid-two-thirds pb-small" for="userAddress">
              <p class="text-left align-self-center">Address</p>    
              <input class=" not-input" type="text" data-type="string" data-min="12" data-max="9999999999" name="inputAddress" placeholder="Address" value="<?= $jLoggedUser['cAddress']; ?>">
              <h5 class="light">Must be 12+ characters</h5>
            </label>

            <label id="cPhoneNo" class="grid grid-two-thirds pb-small" for="userPhone">
              <p class="text-left align-self-center">Phone</p>        
              <input class="phone not-input" type="number" data-type="number" data-min="9999999" data-max="99999999" name="inputPhone" placeholder="phone number" value="<?= $jLoggedUser['cPhoneNo']; ?>">
              <h5 class="light">Must be 8 characters</h5>
            </label>
            <div class="formButtonContainer">
                <button class="button-edit button">Edit information</button>
                <button class="button-save formBtn hide-button button">Save information</button>
            </div>
            </div>
          </form>
        </div>
      
      <div class="profile-details details-two grid"> 
      <h2 class="text-left">Creditcard details</h2>
        <div class="creditcard-container">
        <div class="form-profile-form-container-creditcard bg-grey p-medium">
          <form method="POST" id="savedCardFrm" class="choose-credit-card  grid grid-two-thirds-reversed">
      
          <?php
            if ($statementCreditCard->execute([':id' => $nUserID])) {
              $jUserCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);

              if (count($jUserCreditCards) >= 1) {?>
              <label class=" align-self-center"><p class="text-left pb-small">Your credit cards</p>
                <select  name="userCreditCards" id="">

              <?php
                foreach ($jUserCreditCards as $jUserCreditCard) {
                  $nCreditCardID = $jUserCreditCard['nCreditCardID'];?>

                  <option id="<?= $jUserCreditCard['nCreditCardID'];?>" value="<?= $jUserCreditCard['nCreditCardID'];?>"> <?= $jUserCreditCard['cIBAN'];?></option>       
                <?php
                }
              }
            } ?>

                </select>
              </label>
              <button class="button-delete-card button align-self-bottom">Delete</button>
          </form>
      <div class="creditcard-form-button-container">
      </div>
      <button class="button-add button">Add creditcard</button>
      <form id="form-creditcard" method="post" class="ph-medium mv-medium">
          <label class="grid grid-two-thirds" for="inputIBAN">
            <p class="text-left align-self-center">IBAN</p><h5 class="light text-right">Must be 18 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="number" data-type="string" name="inputIBAN" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputCCV">
            <p class="text-left align-self-center">CCV</p><h5 class="light text-right">Must be 3 digits</h5>
            <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="number" name="inputCCV" value="">
            
          </label>
          <label class="grid grid-two-thirds" for="inputExpiration">
            <p class="text-left align-self-center">Expiration date</p> <h5 class="light text-right">Must be 4 digits</h5>
            <input class="mb-small" data-type="integer" data-min="100" data-max="1999" type="number" name="inputExpiration" value="">
            
          </label>


          <button class="button-save formBtn hide-button button " disabled>Save creditcard</button>
        </form>
      </div>
    
        </div>
      </div>
      </div>
    </section>

    <section class="section-two mv-medium ph-medium mb-large current-subscription">
      <h2 class=" text-left mb-medium">Your current subscriptions</h2>
      <div class="current-subscriptions containerForSubscriptions  grid grid-three m-medium">
        <?php
          if ($statementUserSubscription->execute([':id' => $nUserID])) {
            $jUserSubscriptions = $statementUserSubscription->fetchAll(PDO::FETCH_ASSOC);
           
            if (count($jUserSubscriptions) >= 1) {?>
            

            <?php

              foreach ($jUserSubscriptions as $jUserSubscription) {
                $nProductID = $jUserSubscription['nProductID'];
                $nCoffeeTypeID = $jUserSubscription['nCoffeeTypeID'];
                $nSubscriptionTypeID = $jUserSubscription['nSubscriptionTypeID'];
                $imgUrl = $jUserSubscription['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl)); ?>

              <div class="subscriptionItem" id="<?= $jUserSubscription['nUserSubscriptionID']; ?>">
                <div class="subscriptionItemBg">
                  <img src="img/products/<?= $result; ?>.png" alt="">
                  <h3 class="subscriptionName"><?= $jUserSubscription['cSubscriptionName']; ?></h3>
                  <h4 class="priceSubscription"><?= $jUserSubscription['nPrice']; ?> DKK / Month</h4>
                </div>
                <div class="white-text-bg">
                  <p class="mb-small text-center"><?= $jUserSubscription['cName']; ?></p>
                  <button class="button button-delete">Delete</button>
                </div>
              </div>

        <?php
              }
            }
          }
          ?>
      </div>
    </section>

    <section class="section-three ph-large mb-footer">
      <h2 class="mb-small">Want to try something new?</h2>
      <h3 class="mb-small">Visit the shop and explore a world of quality coffee</h3>
      <div class="related-products relative">
        <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
        <div class="products-container grid grid-four">

          <?php

            if ($statementProducts->execute()) {

              $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);

              foreach ($jProducts as $jProduct) {

                $imgUrl = $jProduct['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
                echo 
                ' <a href="singleProduct?id='.$jProduct['nProductID'].'">
                     <div class="product relative" id="product-'.$jProduct['nProductID'].'">
                         <div class="image bg-contain" style="background-image: url(img/products/'.$result.'.png)"></div>
                         <div class="description m-small">
                             <h3 class="productName mt-small text-left">'.$jProduct['cProductName'].'</h3>
                             <p class="productCoffeeType mt-small text-left">'.$jProduct['cName'].'</p>
                             <h4 class="productPrice mt-small absolute">'.$jProduct['nPrice'].' DKK</h4>
                         </div>
                     </div>
                 </a>'; 
              }
            }; ?>
        </div>
      </div>
<?php
          $connection = null;
}; 

?>


  </div>
  </div>
  </section>
  <button class="button button-delete-profile mb-large">Delete Profile</button>
  </main>
  <script src="js/validation.js"></script>
  <script src="js/sessionStorageCart.js"></script>

  <?php
  $sScriptPath = 'profile.js';
  require_once(__DIR__ . '/components/footer.php');
