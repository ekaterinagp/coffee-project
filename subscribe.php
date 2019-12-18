<?php 
$sTitle = ' | Subscribe';
$sCurrentPage = 'subscribe';
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
$sql = "SELECT tsubscriptiontype.cName, tproduct.cName AS cProductName, tcoffeetype.cName AS cCoffeeTypeName,
                 tsubscriptiontype.nSubscriptionTypeID AS nSubscriptionID, 
                 tproduct.nPrice AS nSubscriptionPrice  
                 FROM tsubscriptiontype 
                 INNER JOIN tproduct 
                 ON tproduct.nProductID = tsubscriptiontype.nProductID
                 INNER JOIN tcoffeetype
                 ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID
                 WHERE tproduct.bActive != 0";
$statement = $connection->prepare($sql);
?>

<main id="subscribePage">
<section class="section-one grid">
<div class="container-banner bg-grey subscribeBanner mb-medium p-small ph-xlarge">
  <div class="content-container grid grid-two relative">
    <div class=" container-header align-items-center color-white">
      <h1 class="color-black">Subscribe Now</h1>
      <p class="banner-message color-black">Get fresh roasted quality coffee delivered to your doorstep so you can enjoy a wonderful cup every morning</p>
    </div>
    <div class="image bg-contain absolute"></div>
    </div>
</div>
</section>

  <div class="containerForSubscriptions grid grid-three m-medium">

  <?php
    if($statement->execute()){
      
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        $connection = null;

        foreach($products as $row){
        $imgUrl = $row['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));

        echo 
        '<div class="subscriptionItem" id="'.$row['nSubscriptionID'].'">
          <div class="subscriptionItemBg">
            <img src="img/products/'.$result.'.png" alt="">  
            <h3 class="subscriptionName">'.$row['cName'].'</h3>
            <h4 class="priceSubscription">'.$row['nSubscriptionPrice'].' DKK / Month</h4>
          </div>
        <div class="white-text-bg">
        <p class="mb-small text-center">'.$row['cCoffeeTypeName'].'</p>
          <p class="descSubscription ph-small">Lorem ipsum dolor sit amet consectetur 
          adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis
          quasi provident nulla minus odit architecto.</p>
          
          </div>
          <button class="addSubToCartBtn button">Add to Cart</button>
        </div>' ;   
  }
}
$connection = null;
?>
  </div>
  <h2 class="text-center mb-small" >In doubt about your coffee of choice?</h2>
  <h3 class="text-center mb-small" >Get a personal recommendation by taking our coffee test</h3>
  <a href="#test"><button id="startBtn" class="button">Start the test</button>
  </a>

  <div id="test" class="testContainer hide margin-auto mt-small mb-footer">
    <div class="testbg bg-brown"></div>
    <div class="intro">
    </div>
    <div class="testContent">
      <h1 id="timeline"></h1>

      <h2 id="question" class="pb-small"></h2>
      <h3 id="questionText"></h3>
      <div id="answer"></div>
    </div>
    <div class="testButtons">
      <button id="backBtn" class="button">Back</button>
      <button id="nextBtn" class="button" disabled>Next</button></div>
  </div>
</main>
<script src="js/sessionStorageCart.js"></script>
<?php
$sScriptPath = 'coffeeTest.js';
require_once(__DIR__.'/components/footer.php');