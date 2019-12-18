<?php
require_once(__DIR__ . '/../connection.php');

// $sql = "SELECT * FROM tsubscriptiontype INNER JOIN tproduct ON tsubscriptiontype.nProductID = tproduct.nProductID WHERE bActive != 0";

$sql = "SELECT tsubscriptiontype.nSubscriptionTypeID, tsubscriptiontype.cName AS cSubscriptionName,
tproduct.nProductID, tproduct.cName AS cProductName, tproduct.nPrice, tproduct.nStock, tproduct.bActive, 
tcoffeetype.nCoffeeTypeID, tcoffeetype.cName  
FROM tsubscriptiontype 
INNER JOIN tproduct ON tsubscriptiontype.nProductID = tproduct.nProductID 
INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID = tcoffeetype.nCoffeeTypeID 
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