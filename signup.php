<?php
$sTitle = ' | Signup';
$sCurrentPage = 'profile';
require_once(__DIR__ . '/components/header.php');


// require_once(__DIR__ . '/connection.php');

session_start();
if ($_SESSION) {
  header("location:profile.php");
}

// if (isset($_POST['reg_user'])) {
//   if (empty($_POST['inputEmail'])) {
//     return;
//   }
//   if (!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (empty($_POST['inputName'])) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (strlen($_POST['inputName']) < 2) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (strlen($_POST['inputName']) > 20) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (empty($_POST['inputLastName'])) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }

//   if (empty($_POST['login'])) {
//     sendErrorMessage('login is empty', __LINE__);
//     return;
//   }

//   if (strlen($_POST['login']) < 2) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (strlen($_POST['login']) > 12) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }

//   if (strlen($_POST['inputLastName']) < 2) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (strlen($_POST['inputLastName']) > 20) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (empty($_POST['password'])) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }
//   if (strlen($_POST['password']) !== 8) {
//     sendErrorMessage('email is empty', __LINE__);
//     return;
//   }






// $strName = $_POST['inputName'];
// $strLastName = $_POST['inputLastName'];
// $strEmail = $_POST['inputEmail'];
// $strPassword = $_POST['password'];
// $strUserLogin = $_POST['login'];
// // $sUserAge = $_POST['age'];

// $user = new stdClass();


// $user->name = $strName;
// // $user->age = $sUserAge;
// $user->lastName = $strLastName;
// $user->email = $strEmail;
// $user->password = $strPassword;
// $user->userType = $strUserType;
// $user->img = 'default.png';
// $user->id = uniqid();
// $user->active = "1";
// if ($strUserType == "user") {
//   $user->liked = [];
// }



// $sDataUsers = file_get_contents(__DIR__ . '/data/users.json');
// $jDataUsers = json_decode($sDataUsers);
// array_push($jDataUsers, $user);

// $sDataUsers = json_encode($jDataUsers, JSON_PRETTY_PRINT);
// file_put_contents(__DIR__ . '/data/users.json', $sDataUsers);

// unset($user->password);
// session_start();
// $_SESSION['user'] = $user;
// header("location:profile.php?name=$strName");
// }

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
        <select name="regionsInput">
          <option disabled selected value> -- select your region -- </option>
          <option value="1">Zealand Region</option>
          <option value="2">Capital City Region</option>
          <option value="3">Mid Jutland Region</option>
          <option value="4">North Jutland Region</option>
          <option value="5">Southern Denmark Region</option>
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
  <script src="signup.js"></script>
  <?php
  $sScriptPath = 'validation.js';
  require_once(__DIR__ . '/components/footer.php');
  ?>