<?php
require_once(__DIR__ . '/../connection.php');

$sql = "SELECT * FROM tproduct";

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
