<?php
require_once(__DIR__ . '/../connection.php');

$sql = "SELECT * FROM tproduct";

$statement = $connection->prepare($sql);

if ($statement->execute()) {

$result = $statement->fetchAll();
$resultArray = json_encode($result);

echo $resultArray;
}

