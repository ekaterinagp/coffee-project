<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sTitle = ' | Log in';
$sCurrentPage = 'log in';
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/header.php');

if ($_SESSION) {
  header("location:profile");
}

?>
<section class="containerSignup grid grid-two">
<div class="container-banner absolute pv-large bg-medium-light-brown"></div>
  <div class="loginWelcome m-medium pb-medium bg-grey">
    <!-- <div class="signupBg "></div> -->
  

        <h1 class="p-small text-center">log in</h1>
      
      <form id="loginForm" class="mv-medium" method="POST">
              <label for="email" class="grid">
            <p class="text-left align-self-center pt-small">Email | Username</p>
            <input class="text-left" required data-type="string" data-min="2" data-max="255" name="inputEmail" placeholder="email" type="text" value="jakob@gmail.com">
            <div class="errorMessage" id="emailDiv">Please enter a valid e-mail or username</div>
          </label>

          <label for="password" class="grid">
            <p class="text-left align-self-center pt-small">Password</p>
            <input class="text-left"  required data-type="string" data-min="8" data-max="8" type="password" name="password" placeholder="password" value="12345678">
            <div class="errorMessage">Password must be 8 characters</div>
          </label>


        <button id="loginBtn" class="formBtn button" >Log in</button>
      </form>
    </div>
  </div>

  <h4 class="text-left mt-Xlarge">Not already a user? <strong><a href="sign-up">Sign up</a></strong></h4>
</section>
<?php
$sScriptPath = 'validation.js';
require_once(__DIR__ . '/components/footer.php');
