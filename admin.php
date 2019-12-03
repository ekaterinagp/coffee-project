<?php 
$sTitle = ' | Admin'; // Should get the username maybe? :-)
// require_once(__DIR__.'/components/header.php');
require_once(__DIR__.'/connection.php');
$sql = "SELECT * FROM tProduct";
// $sProductName;
// $sProductPrice;
// $sProductStock
// foreach ($connection->query($sql) as $row) {
//     $row['cName'] . "\t";

    
//   }
// $stmt = $pdo->prepare("UPDATE tproduct SET cName= :name WHERE nProductID = :id");
// $stmt->execute([':name' => 'David', ':id' => $_SESSION['id']]);
// $stmt = null;

?>

<main>

<h1>Update Products</h1>

<?php
// echo $sjProperties;
    foreach($connection->query($sql) as $row){
            echo '
            <div class="product" id="product-'.$row['nProductID'].' ">
            <h3 class="productName">'.$row['cName'].' kr.</h3>
            <p class="propertyPrice">'.$row['nPrice'].'</p>
            <p class="propertyStock">'.$row['nStock'].'</p>
            </div>
            ';
        }   

    
?>

<label for="">Update Price<input type="text" name="newPrice"></label>
<label for="">Update Stock<input type="text" name="newStock"></label>
<button>Delete Product</button>

</main>

<?php
$sScriptPath = 'script.js';
require_once(__DIR__.'/components/footer.php');