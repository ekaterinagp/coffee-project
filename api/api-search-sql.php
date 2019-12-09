<?php

require_once(__DIR__ . '/../connection.php');

if (empty($_GET['search']) && $_GET['search'] !== '0') {
  echo '[]';
  exit;
}

$sSearchInput = $_GET['search'];

$query = "SELECT tproduct.cName AS productName, tproduct.nProductID,tproduct.nPrice, tcoffeetype.cName AS typeName, tcoffeetype.nCoffeeTypeID FROM  tproduct LEFT JOIN tcoffeetype ON tproduct.nCoffeeTypeID=tcoffeetype.nCoffeeTypeID HAVING  productName LIKE '%" . $sSearchInput . "%'
OR  typeName LIKE '%" . $sSearchInput . "%'";


$statement = $connection->prepare($query);



if ($statement->execute()) {
  $result = $statement->fetchALL();
  $arrayMatches = [];

  foreach ($result as $searchResult) {

    if ($searchResult !== false) {
      array_push($arrayMatches, $searchResult);
    }
  }
  echo json_encode($arrayMatches);
}
