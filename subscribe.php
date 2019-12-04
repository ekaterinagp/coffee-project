<?php 
$sTitle = ' | Front page';
$sCurrentPage = 'frontpage';
require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
?>



<main id="subscribePage">
<div class="grid grid-almost-two section-one container-header align-items-center bg-grey p-large subscribeBanner">
  <div>
<h1>Subscribe Now</h1>
<p class="align-self-top mt-small mb-medium">Get fresh roasted quality coffee delivered to your doorstep so you can enjoy a wonderful cup every morning</p>
</div>
<div class="grid grid-two">
  <img src="img/hario2.png" alt="">
  <img src="img/french2.png" alt="">
</div>
</div>

<h1 class="text-center">Six great ways to subscribe</h1>
  <div class="containerForSubscriptions grid grid-three m-medium ">

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
    }
    
    foreach($products as $row){
      $imgUrl = $row['cProductName'];
      $result = strtolower(str_replace(" ", "-", $imgUrl));
// echo $row['nSubscriptionTypeID'];
echo '<div class="subscriptionItem">
  <div class="itemSize coffeeItemimg1" id="'.$row['nsubscriptionID'].'">
  <img src="img/products/'.$result.'.png" alt="">  
    <h3>'.$row['cName'].'</h3>
    <p class="priceSubscription">'.$row['nSubscriptionPrice'].'</p>
    <p class="descSubscription">Lorem ipsum dolor sit amet consectetur 
    adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis
     quasi provident nulla minus odit architecto enim facilis, ea veniam at
      ullam eligendi excepturi dolore tempora?</p>
  </div>
</div>' ;   }
    ?>


   
  </div>
  

  <h2>In doubt what to choose? Take a test!</h2>

  <div class="testContainer">
    <div class="intro">
      <h2>Wanna get reccomendations? Take a coffee test! </h2><button id="startBtn">Start</button>
    </div>
    <div class="testContent">
      <h1 id="timeline"></h1>

      <h1 id="question"></h1>
      <h2 id="questionText"></h2>
      <div id="answer"></div>
    </div>
    <div class="testButtons">
      <button id="backBtn">Back</button>
      <button id="nextBtn" disabled>Next</button></div>
  </div>


</main>
<?php
$sScriptPath = 'coffeeTest.js';
require_once(__DIR__.'/components/footer.php');