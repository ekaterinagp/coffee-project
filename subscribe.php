<?php 
$sTitle = ' | Front page';
$sCurrentPage = 'subscribe';
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
?>

<main id="subscribePage">
<div class="grid grid-almost-two section-one container-header align-items-center mt-large bg-grey pv-small ph-large subscribeBanner">
  <div>
    <h1>Subscribe Now</h1>
    <p class="align-self-top mt-small mb-medium">Get fresh roasted quality coffee delivered to your doorstep so you can enjoy a wonderful cup every morning</p>
  </div>
  <div class="grid grid-two">
    <img src="img/hario2.png" alt="">
    <img src="img/french2.png" alt="">
  </div>
</div>

  <h2 class="text-center mv-medium ">Six great ways to subscribe</h2>
<div class="containerForSubscriptions grid grid-three m-medium">

  <?php
    $sql = "SELECT tsubscriptiontype.cName, tproduct.cName as cProductName,
                 tsubscriptiontype.nSubscriptionTypeID as nsubscriptionID, 
                 tProduct.nPrice as nSubscriptionPrice 
                 FROM tsubscriptiontype 
                 INNER JOIN tproduct 
                 on tproduct.nProductID=tsubscriptiontype.nProductID";
    
    $statement = $connection->prepare($sql);
    if($statement->execute()){
      
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($products as $row){
        $imgUrl = $row['cProductName'];
        $result = strtolower(str_replace(" ", "-", $imgUrl));
        // echo $row['nSubscriptionTypeID'];

        echo 
        '<div class="subscriptionItem" id="'.$row['nsubscriptionID'].'">
          <div class="subscriptionItemBg">
            <h4 class="subscribeOptiopnP">Option</4>
            <h1 class="subscribeTypeNumber">1</h1>
            <img src="img/products/'.$result.'.png" alt="">  
            <h2>'.$row['cName'].'</h2>
          </div>
        <div class="white-text-bg">
          <p class="descSubscription">Lorem ipsum dolor sit amet consectetur 
          adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis
          quasi provident nulla minus odit architecto.</p>
          <h3 class="priceSubscription">'.$row['nSubscriptionPrice'].' DKK</h3>
          </div>
        </div>' ;   
  }
}
?>

  </div>

  <h2 class="text-center" >In doubt what to choose?</h2>
  <h3 class="text-center" >Wanna get reccomendations? Take a coffee test! </h3>
  <button id="startBtn" class="button">Start</button>

  <div class="testContainer hide margin-auto mv-small bg-grey">
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

<?php
$sScriptPath = 'coffeeTest.js';
require_once(__DIR__.'/components/footer.php');