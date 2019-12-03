<?php 
$sTitle = ' | Payment';
$sCurrentPage = 'payment';
require_once(__DIR__.'/components/header.php');
?>
  <main id="paymentMain">

    <div id="selectedItem"></div>
    <div id="paymentOverview">
      <h1 id="youSelected"> </h1>
      <img src="" />
      <p id="sumTopay"></p>
    </div>
  </main>

<?php
$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');