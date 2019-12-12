<?php 
$sTitle = ' | Subscribe';
$sCurrentPage = 'subscribe';
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
$sql = "SELECT tSubscriptiontype.cName, tProduct.cName AS cProductName, tCoffeeType.cName AS cCoffeeTypeName,
                 tSubscriptiontype.nSubscriptionTypeID AS nSubscriptionID, 
                 tProduct.nPrice AS nSubscriptionPrice  
                 FROM tSubscriptiontype 
                 INNER JOIN tProduct 
                 ON tProduct.nProductID = tSubscriptiontype.nProductID
                 INNER JOIN tCoffeeType
                 ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID";
$statement = $connection->prepare($sql);
?>

<main id="subscribePage">
<div class="grid grid-almost-two section-one container-banner align-items-center bg-grey  subscribeBanner ph-large p-small">
  <div>
    <h1>Subscribe Now</h1>
    <p class="align-self-top mt-small mb-medium mr-medium">Get fresh roasted quality coffee delivered to your doorstep so you can enjoy a wonderful cup every morning</p>
  </div>
    <img src="img/coffee-beans.png" class="absolute" alt="">
  
</div>

  <h2 class="text-center mv-medium ">Six great ways to subscribe</h2>
  <div class="containerForSubscriptions grid grid-three m-medium">

  <?php
    if($statement->execute()){
      
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        $connection = null;

        foreach($products as $row){
        $imgUrl = $row['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
        // echo $row['nSubscriptionTypeID'];

        echo 
        '<div class="subscriptionItem" id="'.$row['nSubscriptionID'].'">
          <div class="subscriptionItemBg">
            <img src="img/products/'.$result.'.png" alt="">  
            <h2 class="subscriptionName">'.$row['cName'].'</h2>
          </div>
        <div class="white-text-bg">
          <p class="descSubscription p-small">Lorem ipsum dolor sit amet consectetur 
          adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis
          quasi provident nulla minus odit architecto.</p>
          <h3 class="priceSubscription p-small">'.$row['nSubscriptionPrice'].' DKK / Month</h3>
          </div>
          <button class="addSubToCartBtn button">Add to Cart</button>
        </div>' ;   
  }
}
$connection = null;
?>
  </div>
  
  
  <h2 class="text-center" >In doubt what to choose?</h2>
  <h3 class="text-center" >Want to get reccomendations? Take a coffee test! </h3>
  <a href="#test"><button id="startBtn" class="button">Start</button>
  </a>

  <div id="test" class="testContainer hide margin-auto mv-small ">
    <div class="testbg bg-brown"></div>
    <div class="intro">
    </div>
    <div class="testContent">
      <h1 id="timeline"></h1>

      <h2 id="question"></h2>
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