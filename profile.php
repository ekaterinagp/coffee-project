<?php

$sTitle = '| Your profile';
$sCurrentPage = 'profile';

require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/functions.php');

if (!$_SESSION) {
  header('Location: log-in');
  exit;
}

if ($_SESSION) {

  $jLoggedUser = $_SESSION['user'];
  $nUserID = $jLoggedUser['nUserID'];

  if (isset($jLoggedUser['dDeleteUser'])) {
    header('Location: log-in');
    exit;
  }

  $sqlProducts = "SELECT tProduct.nProductID, tProduct.cName AS cProductName, 
                tProduct.nCoffeeTypeID AS nProductCoffeeTypeID, tProduct.nPrice, 
                tProduct.nStock, tProduct.bActive, tCoffeeType.nCoffeeTypeID, tCoffeeType.cName 
                FROM tProduct INNER JOIN tCoffeeType on tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID WHERE tProduct.bActive != 0 LIMIT 4";
  $statementProducts = $connection->prepare($sqlProducts);


  // SUBSCRIPTIONS THAT THE USER IS NOT SUBSCRIBED TO
  // $sqlSubscriptions = "SELECT DISTINCT tSubscriptiontype.cName, tSubscriptiontype.nSubscriptionTypeID AS nSubscriptionID, 
  //                   tProduct.cName AS cProductName, tProduct.nPrice AS nSubscriptionPrice, tProduct.bActive,
  //                   tCoffeeType.cName AS cCoffeeTypeName 
  //                   FROM tSubscriptiontype 
  //                   INNER JOIN tProduct ON tProduct.nProductID=tsubscriptiontype.nProductID
  //                   INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID 
  //                   INNER JOIN tUserSubscription ON tUserSubscription.nSubscriptionTypeID = tSubscriptionType.nSubscriptionTypeID
  //                   WHERE tProduct.bActive != 0 AND tUserSubscription.nUserID = :id";

  // $statementSubscriptions = $connection->prepare($sqlSubscriptions);

  $sqlUserSubscription = "SELECT tUserSubscription.nUserSubscriptionID, tUserSubscription.dCancellation, 
                        tSubscriptionType.nSubscriptionTypeID, tSubscriptionType.cName AS cSubscriptionName,
                        tProduct.nProductID, tProduct.cName AS cProductName, tProduct.nPrice, tProduct.nStock, tProduct.bActive, 
                        tCoffeeType.nCoffeeTypeID, tCoffeeType.cName  
                        FROM tUser
                        INNER JOIN tUserSubscription ON tUser.nUserID = tUserSubscription.nUserID 
                        INNER JOIN tSubscriptionType ON tUserSubscription.nSubscriptionTypeID = tSubscriptionType.nSubscriptionTypeID 
                        INNER JOIN tProduct ON tSubscriptionType.nProductID = tProduct.nProductID 
                        INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID 
                        WHERE tuser.nUserID = :id AND tUserSubscription.dCancellation IS NULL AND tProduct.bActive != 0";

  $statementUserSubscription = $connection->prepare($sqlUserSubscription);

  $sqlCreditCard = "SELECT * FROM tCreditCard WHERE tCreditCard.nUserID = :id AND dDeleteCreditCard IS NULL";
  $statementCreditCard = $connection->prepare($sqlCreditCard);

  ?>

  <main class="profile">
    <h1 class="text-center pt-medium">Welcome <?= $jLoggedUser['cName']; ?></h1>
    <section class="section-one grid  ph-large mv-medium">

      <div>
        <div class="profile-details bg-grey p-medium pt-medium">
          <h2 class="">Profile Details</h2>
          <form id="form-profile" class=" grid grid-three pt-small ph-medium" method="post">
            <label id="cName" class="grid" for="name">
              <p class="text-left align-self-center">Name</p>
              <input class=" not-input" data-type="string" data-min="2" data-max="20" type="text" data-type="string" name="inputName" placeholder="First name" value="<?= $jLoggedUser['cName']; ?>">
              <div class="errorMessage">Name must be more than 1 and less than 20 letters</div>
            </label>

            <label id="cSurname" class="grid" for="lastName">
              <p class="text-left align-self-center">Last Name</p>
              <input class="  not-input" data-type="string" data-min="2" data-max="20" type="text" name="inputLastName" placeholder="Last name" value="<?= $jLoggedUser['cSurname']; ?>">
              <div class="errorMessage">Last name must be more than 1 and less than 20 letters</div>
            </label>

            <label class="grid" for="loginName">
              <p class="text-left align-self-center">Username</p>
              <input class=" not-input" type="text" data-type="string" data-min="2" data-max="12" name="inputLoginName" placeholder="username" value="<?= $jLoggedUser['cUsername']; ?>">
              <div class="errorMessage">Must be more than 2 and less than 12</div>
            </label>

            <label id="cEmail" class="grid" for="email">
              <p class="text-left align-self-center">Email</p>
              <input class=" not-input" type="email" data-type="email" name="inputEmail" placeholder="email" value="<?= $jLoggedUser['cEmail']; ?>">
              <div class="errorMessage" id="emailDiv">Must be a valid email address</div>
            </label>
            <label id="nCityID" for="cityInput" class="grid">
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
            </label>
            <label id="cAddress" class="grid" for="userAddress">
              <p class="text-left align-self-center">Address</p>
              <input class=" not-input" type="text" data-type="string" data-min="12" data-max="9999999999" name="inputAddress" placeholder="Address" value="<?= $jLoggedUser['cAddress']; ?>">
              <div class="errorMessage">Must be more than 12 characters</div>
            </label>

            <label id="cPhoneNo" class="grid" for="userPhone">
              <p class="text-left align-self-center">Phone</p>
              <input class=" not-input" type="number" data-type="number" data-min="9999999" data-max="99999999" name="inputPhone" placeholder="phone number" value="<?= $jLoggedUser['cPhoneNo']; ?>">
              <div class="errorMessage">Must be 8 characters</div>
            </label>

            <div class="formButtonContainer">
              
                <button class="button-edit button">Edit information</button>
                <button class="button-save formBtn hide-button button">Save information</button>
              
             
            </div>

          </form>
        </div>
      </div>
      <div class="profile-details bg-grey p-medium pt-medium">

      
        <div class="creditcard-container ph-medium ">
          <h2 class="">Creditcard Details</h2>
          <form method="POST" id="savedCardFrm" class=" pt-small choose-credit-card grid grid-two-thirds-reversed">
      
          <?php
            if ($statementCreditCard->execute([':id' => $nUserID])) {
              $jUserCreditCards = $statementCreditCard->fetchAll(PDO::FETCH_ASSOC);

              if (count($jUserCreditCards) >= 1) {?>
              <label><p class="text-left align-self-center ">Your credit cards</p>
                <select class="align-self-center" name="userCreditCards" id="">

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

      </div>
      <button class="button-add button">Add creditcard</button>
      <form id="form-creditcard" method="post" class="mt-medium">

          <label class="grid" for="inputIBAN">
            <p class="text-left align-self-center">IBAN</p>
            <input class="mb-small" data-type="integer" data-min="99999999999999999" data-max="999999999999999999" type="number" data-type="string" name="inputIBAN" placeholder="IBAN (format 123456789123456789)" value="">
            <div class="errorMessage">IBAN must be 18 digits</div>
          </label>

          <label class="grid" for="inputCCV">
            <p class="text-left align-self-center">CCV</p>
            <input class="mb-small" data-type="integer" data-min="99" data-max="999" type="number" name="inputCCV" placeholder="CCV (format 123)" value="">
            <div class="errorMessage">CCV must be 3 digits</div>
          </label>

          <label class="grid" for="inputExpiration">
            <p class="text-left align-self-center">Expiration date</p>
            <input class="mb-small" data-type="integer" data-min="999" data-max="9999" type="number" name="inputExpiration" placeholder="Expiration date (format mmyy)" value="">
            <div class="errorMessage">Expiration date must be 4 digits</div>
          </label>


          <button class="button-save formBtn hide-button button " disabled>Save creditcard</button>
        </form>
      </div>
    </section>


    <section class="section-two mv-medium ph-medium pt-medium current-subscription">
      <h2 class=" text-left mb-medium">Your current subscriptions</h2>
      <div class="current-subscriptions containerForSubscriptions  grid grid-three m-medium">

        <?php
          if ($statementUserSubscription->execute([':id' => $nUserID])) {
            $jUserSubscriptions = $statementUserSubscription->fetchAll(PDO::FETCH_ASSOC);

            if (count($jUserSubscriptions) >= 1) {
              $arrayProductID = [];
              $arrayCoffeeTypeID = [];
              $arraySubscriptionTypeID = [];

              foreach ($jUserSubscriptions as $jUserSubscription) {

                // if(!isset($jUserSubscription['dCancellation'])){
                // echo $jUserSubscription['dCancellation'];

                // if($jUserSubscription['bActive']!==0){

                $nProductID = $jUserSubscription['nProductID'];
                // array_push($arrayProductID, $nProductID);

                $nCoffeeTypeID = $jUserSubscription['nCoffeeTypeID'];
                // array_push($arrayCoffeeTypeID, $nCoffeeTypeID);

                $nSubscriptionTypeID = $jUserSubscription['nSubscriptionTypeID'];
                // array_push($arraySubscriptionTypeID, $nSubscriptionTypeID);

                $imgUrl = $jUserSubscription['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));; ?>

              <div class="subscriptionItem" id="<?= $jUserSubscription['nUserSubscriptionID']; ?>">
                <div class="subscriptionItemBg">
                  <img src="img/products/<?= $result; ?>.png" alt="">
                  <h3><?= $jUserSubscription['cSubscriptionName']; ?></h3>
                  <h4><?= $jUserSubscription['cName']; ?></h4>
                </div>
                <div class="white-text-bg">
                  <button class="button button-delete">Cancel subscription</button>
                </div>
              </div>

        <?php
                // }
                // }
              }
            }
          }
          ?>
      </div>
    </section>

    <section class="section-three mb-large ph-large pt-medium">
      <h2 class="mb-medium">Want to try something new?</h2>
      <div class="related-products relative">
        <!-- <h2 class="coffee-type text-left mb-medium">Products</h2> -->
        <div class="container-banner absolute pv-large bg-medium-light-brown"></div>
        <div class="products-container grid grid-four">

          <?php

            if ($statementProducts->execute()) {

              $jProducts = $statementProducts->fetchAll(PDO::FETCH_ASSOC);
              // $arrayRelatedProducts = [];

              foreach ($jProducts as $jProduct) {

                // $nRelatedProductCoffeeTypeID = $jProduct['nCoffeeTypeID'];
                // $nRelatedProductID = $jProduct['nProductID'];

                // if(!in_array($nRelatedProductID, $arrayProductID)){

                // array_push($arrayRelatedProducts, $nRelatedProductID);

                $imgUrl = $jProduct['cProductName'];
                $result = strtolower(str_replace(" ", "-", $imgUrl));
                ?>
              <a href="singleProduct?id=<?= $jProduct['nProductID']; ?>">
                <div class="product" id="product-<?= $jProduct['nProductID']; ?>">
                  <div class="image bg-contain" style="background-image: url(img/products/<?= $result; ?>.png)"></div>
                  <div class="description m-small">
                    <h3 class="productName mt-small text-left"><?= $jProduct['cProductName']; ?></h3>
                    <h4 class="productName mt-small text-left">Origin: <?= $jProduct['cName']; ?></h4>
                    <h4 class="priceProduct mt-small"><?= $jProduct['nPrice']; ?> DKK</h4>
                  </div>
                </div>
              </a>
        
<?php
                // }
              }
            }; ?>
        </div>
      </div>
<?php
          $connection = null;
}; ?>


  </div>
  </div>
  <button class="button button-delete-profile m-medium">Delete Profile</button>
  </section>
  </main>
  <script src="js/validation.js"></script>
  <script src="js/sessionStorageCart.js"></script>

  <?php
  $sScriptPath = 'profile.js';
  require_once(__DIR__ . '/components/footer.php');
