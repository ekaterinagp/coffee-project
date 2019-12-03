<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Subscribe</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Choose a subscription</h1>
  <div class="containerForSubscriptions">
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg1" id="1">
        <h3>Subscription 1</h3>
        <p class="priceSubscription">250kr</p>
        <p class="descSubscription">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate praesentium, inventore deleniti optio nobis quasi provident nulla minus odit architecto enim facilis, ea veniam at ullam eligendi excepturi dolore tempora?</p>
      </div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg2" id="2">Subscription 2</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg3" id="3">Subscription 3</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg4" id="4">Subscription 4</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg5" id="5">Subscription 5</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg6" id="6">Subscription 6</div>
    </div>
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

</body>
<script src="script.js"></script>
<script src="coffeeTest.js"></script>

</html>