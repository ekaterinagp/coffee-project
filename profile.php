<?php

require_once(__DIR__ . '/components/header.php');
require_once(__DIR__ . '/components/functions.php');

if(!$_SESSION){
  header('Location: login.php');
  exit;
}

$jLoggedUser = $_SESSION['user'];

$sTitle = ' | Your profile'; 
$sCurrentPage = 'Profile';
?>

<main>

<section class="section-one grid grid-two mb-large ph-large pt-medium">

  <h1>Welcome <?= $jLoggedUser['cName'];?></h1>
  <div class="profile-details bg-medium-light-brown p-medium">
    <form id="form-profile" method="post">
      <label id="cName" class="grid grid-one-fourth" for="name"><h3 class="text-left align-self-center">Name</h3>
        <input class="m-small" minlength="2" maxlength="20" type="text" data-type="string" name="inputName" placeholder="First name">
        <div class="errorMessage">Name must be more than 1 and less than 20 letters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cSurname" class="grid grid-one-fourth" for="lastName"><h3 class="text-left align-self-center">Last Name</h3>
        <input class="m-small" data-type="string" minlength="2" maxlength="20" type="text" name="inputLastName" placeholder="Last name">
        <div class="errorMessage">Last name must be more than 1 and less than 20 letters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cEmail" class="grid grid-one-fourth" for="email"><h3 class="text-left align-self-center">Email</h3>
        <input class="m-small" type="email" data-type="email" name="inputEmail" placeholder="email">
        <div class="errorMessage" id="emailDiv">Must be a valid email address</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>
      <label id="nCityID" for="cityInput" class="grid grid-one-fourth"><h3 class="text-left align-self-center">City</h3>
        <select class="m-small" name="cityInput">
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
          <button class="button-edit button">Edit</button>
          <button class="button-save hide-button button">Save</button>
        </label>
      <label id="cAddress" class="grid grid-one-fourth" for="userAddress"><h3 class="text-left align-self-center">Address</h3>
        <input class="m-small" type="text" data-type="string" name="inputAddress" placeholder="address ">
        <div class="errorMessage">Must be more than 12 characters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <label id="cPhoneNo" class="grid grid-one-fourth" for="userPhone"><h3 class="text-left align-self-center">Phone</h3>
        <input class="m-small" type="text" data-type="string" name="inputPhone" placeholder="phone number">
        <div class="errorMessage">Must be 8 characters</div>
        <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label>

      <!-- <label class="grid grid-one-fourth" for="loginName"><h3 class="text-left align-self-center">Username</h3>
        <input type="text" data-type="string" name="inputLoginName" placeholder="username">
          <div class="errorMessage">Must be more than 2 and less than 12</div>
          <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
        </label>

      <label class="grid grid-one-fourth" for="password"><h3 class="text-left align-self-center">Password</h3>
        <input type="password" data-type="string" minlength="8" maxlength="8" name="password" placeholder="password">
          <div class="errorMessage">Password must be 8 characters</div>
          <button class="button-edit button">Edit</button>
        <button class="button-save hide-button button">Save</button>
      </label> -->
    </form>
  </div>
  

</section>

<section class="section-two grid grid-two mb-large ph-medium pt-medium current-subscription">
  <div class="current-subscription">
    <h2 class="text-left">Your current subscription</h2>
  </div>
  <div class="current-subscription-details"></div>

</section>

<section class="section-three mb-large ph-large pt-medium">

<h2>Want to try something new</h2>

</section>

</main>

<?php
$sScriptPath = 'profile.js';
require_once(__DIR__ . '/components/footer.php');
