<?php
require_once(__DIR__ . '/../connection.php');

$query = "SELECT * FROM tproduct";

$statement = $connection->prepare($query);

if ($statement->execute()) {

$result = $connection->query($query)->fetchAll();
$resultArray = json_encode($result);

echo $resultArray;
}