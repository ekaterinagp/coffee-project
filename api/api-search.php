<?php 
// ISSET checks if the variable has been set // Returns TRUE if the variable exists and has a value other than NULL 
// EMPTY checks to see if a variable is empty. Empty is interpreted as: "" (string), 0 (integer), 0.0 (float)`, "0" (string), NULL, FALSE, array(), and "$var;" 

if(empty($_GET['search']) && $_GET['search'] !== '0' && !isset($_GET['search'])){ // why the check for !==0?
    echo '[]';
    exit;
}

$sSearchRequest = $_GET['search'] ?? '';

require_once(__DIR__.'/../connection.php');
$sql = "SELECT * FROM tproduct";
$statement = $connection->prepare($sql);

if ($statement->execute()) {


    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $arrayMatches = [];

    foreach($products as $product){

        if($product['bActive'] !== 0){

            if(stripos($product['cName'], $sSearchRequest) !== false){
            array_push($arrayMatches, $product);
            }
        }
    }

echo json_encode($arrayMatches);

}