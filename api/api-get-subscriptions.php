<?php
require_once(__DIR__ . '/../connection.php');

// $sql = "SELECT * FROM tsubscriptiontype INNER JOIN tproduct ON tsubscriptiontype.nProductID = tproduct.nProductID WHERE bActive != 0";

$sql = "SELECT tSubscriptionType.nSubscriptionTypeID, tSubscriptionType.cName AS cSubscriptionName,
tProduct.nProductID, tProduct.cName AS cProductName, tProduct.nPrice, tProduct.nStock, tProduct.bActive, 
tCoffeeType.nCoffeeTypeID, tCoffeeType.cName  
FROM tSubscriptionType 
INNER JOIN tProduct ON tSubscriptionType.nProductID = tProduct.nProductID 
INNER JOIN tCoffeeType ON tProduct.nCoffeeTypeID = tCoffeeType.nCoffeeTypeID 
WHERE tProduct.bActive != 0";

$statement = $connection->prepare($sql);

if ($statement->execute()) {

  $result = $statement->fetchALL();

  $resultArray = json_encode($result);

  echo $resultArray;
  $connection = null;
  exit;
}

echo 0;
$connection = null;