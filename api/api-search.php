<?php 

require_once(__DIR__.'/../connection.php');

if(empty($_GET['search']) && $_GET['search'] !== '0'){
    echo '[]';
    exit;
}

$sSearchRequest = $_GET['search'];

$sql = "SELECT * FROM tproduct";
$statement = $connection->prepare($sql);

if ($statement->execute()) {

$result = $connection->query($sql)->fetchAll();

$arrayMatches = [];

foreach($result as $product){

    if(stripos($product['cName'], $sSearchRequest) !== false){
        array_push($arrayMatches, $product);
    }
}

echo json_encode($arrayMatches);

}