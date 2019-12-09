<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sTitle = ' | Login';
$sCurrentPage = 'login';
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/header.php');

if ($_SESSION) {
  header("location:profile.php");
}

if ($_POST) {


  if (empty($_POST['inputEmail'])) {
    return;
  }
  // if (!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) {
  //   sendErrorMessage('email is empty', __LINE__);
  //   return;
  // }
  if (empty($_POST['password'])) {
    sendErrorMessage('email is empty', __LINE__);
    // return;
    echo 'empty';
  }
  if (strlen($_POST['password']) !== 8) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }





  $statement = "SELECT * FROM tuser";
  $result = $connection->query($statement)->fetchAll();
  // var_dump($result);
  // $correctUser=null;
  $password = hash("sha224", $_POST['password']);
  $emailInput = $_POST['inputEmail'];

  foreach ($result as $user) {



    if ($password == $user["cPassword"] && ($emailInput == $user["cEmail"]  || $emailInput == $user['cUsername'])) {
      echo "user found!";
      unset($user['cPassword']);
      $_SESSION['user'] = $user;

      header('location:profile.php?name=' . $user['cName'] . '');
    }
  }

  // if ($emailInput == !$user["cEmail"]) {
  //   //turn to frontendnormalvalidation

  //   echo "user with this email is not found";
  // }


  if ($emailInput == $user["cEmail"] && $password !== $user["cPassword"]) {
    echo "wrong password";
  }
}
?>

<div class="loginDiv">
  <div class="">
    <h1>Welcome to Proper Pour!</h1>
    <h2>Please log in</h2>
  </div>
  <form id="loginForm" method="POST">
    <div>
      <label for="email"><input required name="inputEmail" placeholder="email" type="text" value="jakob@gmail.com">
        <div class="errorMessage" id="emailDiv"></div>
      </label>
    </div>

    <div>
      <label for="password"><input required type="password" data-type="string" minlength="8" maxlength="8" name="password" placeholder="password" value="12345678">
        <div class="errorMessage">Password must be 8 characters</div>
      </label>
    </div>


    <button id="loginBtn" disabled>Log in</button>
  </form>
</div>

<?php
$sScriptPath = 'validation.js';
require_once(__DIR__ . '/components/footer.php');
