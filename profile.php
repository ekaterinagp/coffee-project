<?php
$sTitle = ' | Your profile'; // Should get the actual name :-)
$sCurrentPage = 'Profile';
require_once(__DIR__ . '/components/header.php');
echo json_encode($_SESSION['user'] );
?>

<main>

  <section class="section-one">

  </section>
  <section class="section-two"></section>

</main>

<?php
// $sScriptPath = 'js/script.js';
require_once(__DIR__ . '/components/footer.php');
