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
      <div class="itemSize coffeeItemimg1">Subscription 1</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg2">Subscription 2</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg3">Subscription 3</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg4">Subscription 4</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg5">Subscription 5</div>
    </div>
    <div class="subscriptionItem">
      <div class="itemSize coffeeItemimg6">Subscription 6</div>
    </div>
  </div>


  <div class="testContainer">
    <div class="intro">
      <h2>Wanna get reccomendations? Take a coffee test! </h2><button id="startBtn">Start</button>
    </div>
    <div class="testContent">
      <h1 id="timeline"></h1>

      <h1 id="question">Question</h1>
      <h2 id="questionText">Text of the question</h2>
      <div id="answer"></div>
    </div>
    <button id="backBtn">Back</button>
    <button id="nextBtn">Next</button>
  </div>

</body>
<script src="script.js"></script>
<script src="coffeeTest.js"></script>

</html>