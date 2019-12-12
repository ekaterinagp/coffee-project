<?php
$sTitle = ' | Thank you'; // Add the product dynamically
$sCurrentPage = 'Thank you';
require_once(__DIR__ . '/components/header.php');
?>

<main class="m-large">
<h1 class="text-center p-small">Thank you for your purhcase</h1>
<h4 class="text-center p-small">Estimated time of delivery is one day from now.</h4>
<a href="shop" class="m-small link"> Back to shop</a>
<a href="shop" class=" m-small link"> Back to subscribe options</a>
</main>



<?php
$connection = null;
require_once(__DIR__ . '/components/footer.php');
