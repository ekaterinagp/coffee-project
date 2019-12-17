<?php
require_once(__DIR__ . '/../connection.php');
if (empty($_GET['search']) && $_GET['search'] !== '0') {
  echo '[]';
  exit;
}
$sSearchInput = $_GET['search'];

$data = [
  ':search' => $sSearchInput,
  ':search1' => $sSearchInput
];

$query = "SELECT tproduct.cName AS productName, tproduct.nProductID,tproduct.nPrice, tcoffeetype.cName AS typeName, 
tcoffeetype.nCoffeeTypeID FROM  tproduct 
INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID=tcoffeetype.nCoffeeTypeID 
HAVING  productName LIKE CONCAT('%',:search,'%')
OR  typeName LIKE CONCAT('%',:search1,'%')";

$statement = $connection->prepare($query);


if ($statement->execute($data)) {

  $result = $statement->fetchALL();
  $arrayMatches = [];
  foreach ($result as $searchResult) {
    if ($searchResult !== false) {
      array_push($arrayMatches, $searchResult);
      $connection = null;
    }
  }
  echo json_encode($arrayMatches);
  exit;
} else {
  echo 0;
  $connection = null;
  exit;
}

// require_once(__DIR__ . '/../connection.php');
// if (empty($_GET['search']) && $_GET['search'] !== '0') {
//   echo '[]';
//   exit;
// }
// $sSearchInput = $_GET['search'];
// $query = "SELECT tproduct.cName AS productName, tproduct.nProductID,tproduct.nPrice, tcoffeetype.cName AS typeName, 
// tcoffeetype.nCoffeeTypeID FROM  tproduct 
// INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID=tcoffeetype.nCoffeeTypeID 
// HAVING  productName LIKE '%" . $sSearchInput . "%'
// OR  typeName LIKE '%" . $sSearchInput . "%'";
// $statement = $connection->prepare($query);
// if ($statement->execute()) {
//   $result = $statement->fetchALL();
//   $arrayMatches = [];
//   foreach ($result as $searchResult) {
//     if ($searchResult !== false) {
//       array_push($arrayMatches, $searchResult);
//       $connection = null;
//     }
//   }
//   echo json_encode($arrayMatches);
//   exit;
// }
// echo 0;
// $connection = null;
// exit;
