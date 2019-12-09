<?php

require_once(__DIR__ . '/../connection.php');

if (empty($_GET['search']) && $_GET['search'] !== '0') {
  echo '[]';
  exit;
}

$sSearchInput = $_GET['search'];

$query = "SELECT tproduct.cName, tproduct.nProductID, tcoffeetype.cName, tcoffeetype.nCoffeeTypeID FROM  tproduct INNER JOIN tcoffeetype ON tproduct.nCoffeeTypeID=tcoffeetype.nCoffeeTypeID WHERE  tproduct.cName LIKE '%" . $sSearchInput . "%'
OR  tcoffeetype.cName LIKE '%" . $sSearchInput . "%' GROUP BY tproduct.cName";





$result = $connection->query($query)->fetchAll();

// var_dump($result);

$arrayMatches = [];

foreach ($result as $searchResult) {

  if ($searchResult['cName']  !== false) {
    array_push($arrayMatches, $searchResult);
  }
}

echo json_encode($arrayMatches);
