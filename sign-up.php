<?php
$sTitle = ' | Signup';
$sCurrentPage = 'profile';
require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/components/functions.php');

if ($_SESSION) {
  header("location:profile");
  exit;
}
?>
  <section class="containerSignup signup grid grid-two align-items-center">
    <div class="loginWelcome mh-medium pv-medium mb-footer bg-brown">
      <div class="signupBg bg-orange"></div>
      <h1 class="color-white p-small text-center">Signup</h1>


      <form id="signupForm" class="grid grid-one" method="POST">
        <h5 class="mt-small color-white">Personal Information</h5>
        <hr class="frmLine mt-small">

        <label class="grid grid-two-thirds color-white" for="name"><p>First Name</p><h5 class="light text-right">Must be 1 to 20 characters</h5><input required data-min="2" data-max="20" type="text" data-type="string" name="inputName">
        </label>

        <label class="grid grid-two-thirds color-white" for="lastName"><p>Last Name</p> <h5 class="light text-right">Must be 1 to 20 characters</h5><input required data-type="string" data-min="2" data-max="20" type="text" name="inputLastName" >
        </label>

        <label class="grid grid-two-thirds color-white" for="email"><p>Email</p>  <h5 class="light text-right">Must be a valid email address</h5><input required type="email" data-type="email" name="inputEmail" >
        </label>

        <label for="cityInput" class="grid grid-two color-white"><p>City</p> <h5 class="text-right light">Choose your City</h5>
          <select name="cityInput" data-min="0" data-max="99" data-type="integer">
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
        </label>

        <label class="grid grid-two color-white" for="userAddress"><p>Address</p> <h5 class="light text-right">Must be 12+ characters</h5><input required type="text" data-type="string" data-min="12" data-max="9999999999"  name="inputAddress" >
        </label>

        <label class="grid grid-two color-white" for="userPhone"><p>Phone Number</p> <h5 class="light text-right">Must be 8 characters</h5><input required type="text" data-type="integer" data-min="9999999" data-max="999999999" name="inputPhone">
        </label>
        <h5 class="mt-medium color-white">Account Information</h5>

        <hr class="frmLine mt-small">
        <label class="grid grid-two color-white" for="loginName"><p>Username</p> <h5 class="light text-right">Must be 2 to 12 charachters</h5><input required type="text" data-type="string" data-min="2" data-max="12"  name="inputLoginName">
        </label>

        <label class="grid grid-two color-white" for="password"><p>Password</p> <h5 class="light text-right">Password must be 8 characters</h5><input required type="password" data-type="string" data-min="8" data-max="8" name="password_1" >
        </label>

        <label class="grid grid-two color-white" for="password"><p>Repeat Password</p><h5 class="light text-right">Passwords must match</h5> <input required type="password" data-type="string" data-min="8" data-max="8" name="password_2">
        </label>


        <button name="reg_user" class="button formBtn margin-auto mv-small" disabled>Sign Up</button>
      </form>
    </div>
    <h4 class="text-left">Already a user? <strong><a href="log-in">Log in </a></strong></h3>
</section>
  <script src="js/signup.js"></script>
  <?php
  $sScriptPath = 'validation.js';
  require_once(__DIR__ . '/components/footer.php');
  ?>