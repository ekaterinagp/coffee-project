<?php

$sTitle = ' | Log in';
$sCurrentPage = 'log in';
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/components/header.php');

if ($_SESSION) {
  header("location:profile");
}

?>
<section class="containerLogin grid grid-two align-items-center">

  <div class="loginWelcome mh-medium pv-medium bg-brown">
  <div class="signupBg bg-orange"></div>

        <h1 class="color-white p-small text-center">log in</h1>
      
      <form id="loginForm" class="mv-medium" method="POST">
              <label for="email" class="grid grid-two  color-white">
            <p class="text-left align-self-center pv-small">Email | Username</p> <h5 class="light text-right pv-small">Must be a valid e-mail or username</h5>
            <input class="text-left" required data-type="string" data-min="2" data-max="255" name="inputEmail" placeholder="Email | Username" type="text" value="jakob@gmail.com">
            <!-- <div class="errorMessage" id="emailDiv">Please enter a valid e-mail or username</div> -->
          </label>

          <label for="password" class="grid grid-two-thirds color-white">
            <p class="text-left align-self-center pv-small">Password</p> <h5 class="light text-right pv-small">Password must be 8 characters</h5>
            <input class="text-left"  required data-type="string" data-min="8" data-max="8" type="password" name="password" placeholder="Password" value="12345678">
            <!-- <div class="errorMessage">Password must be 8 characters</div> -->
          </label>


        <button id="loginBtn" class="formBtn button margin-auto mv-small" >Log in</button>
      </form>
    </div>
  </div>

  <h4 class="text-left">Not already a user? <strong><a href="sign-up">Sign up</a></strong></h4>
</section>
<?php
$sScriptPath = 'validation.js';
require_once(__DIR__ . '/components/footer.php');
