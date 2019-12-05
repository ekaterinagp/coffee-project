<?php
$sTitle = ' | Signup';
$sCurrentPage = 'profile';
require_once(__DIR__ . '/components/header.php');




session_start();
if ($_SESSION) {
  header("location:profile.php");
}



function sendErrorMessage($txtError, $iLineNumber)
{
  echo '{"status":0, "message":"' . $txtError . '", "line":' . $iLineNumber . '}';
  exit;
}



?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <script src="https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css" rel="stylesheet" />

</head>

<body>




  <div class="containerSignup">
    <div class="loginWelcome">

      <h2>Please sign up</h2>
    </div>
    <form id="signupForm" method="POST">


      <div>
        <label for="name"><input required minlength="2" maxlength="20" type="text" data-type="string" name="inputName" placeholder="First name">
          <div class="errorMessage">Name must be more than 1 and less than 20 letters</div>
        </label>
      </div>

      <div>
        <label for="lastName"><input required data-type="string" minlength="2" maxlength="20" type="text" name="inputLastName" placeholder="Last name">
          <div class="errorMessage">Last name must be more than 1 and less than 20 letters</div>
        </label>
      </div>

      <div>
        <label for="email"><input required type="email" data-type="email" name="inputEmail" placeholder="email">
          <!-- onchange="fvIsEmailAvailable(this);"  -->
          <div class="errorMessage" id="emailDiv">Must be a valid email address</div>
        </label>
      </div>
      <div>
        <select name="cityInput">
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
      </div>
      <div>
        <label for="userAddress"><input required type="text" data-type="string" name="inputAddress" placeholder="address">
          <div class="errorMessage">Must be more than 12 characters</div>
        </label>
      </div>
      <div>
        <label for="userPhone"><input required type="text" data-type="string" name="inputPhone" placeholder="phone number">
          <div class="errorMessage">Must be 8 characters</div>
        </label>
      </div>
      <div>
        <label for="loginName"><input required type="text" data-type="string" name="inputLoginName" placeholder="user name">
          <div class="errorMessage">Must be more than 2 and less than 12</div>
        </label>
      </div>

      <div>
        <label for="password"><input required type="password" data-type="string" minlength="8" maxlength="8" name="password_1" placeholder="password">
          <div class="errorMessage">Password must be 8 characters</div>
        </label>
      </div>
      <div>
        <label for="password"><input required type="password" data-type="string" minlength="8" maxlength="8" name="password_2" placeholder="repeat password">
          <div class="errorMessage">Password must match</div>
        </label>
      </div>


      <button name="reg_user" disabled>Sign Up</button>
    </form>

    <h3>Already a user? <a href="login.php">Log in </a></h3>
  </div>
  <script src="js/signup.js"></script>
  <?php
  $sScriptPath = 'js/validation.js';
  require_once(__DIR__ . '/components/footer.php');
  ?>