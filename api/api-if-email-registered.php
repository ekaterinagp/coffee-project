<?php

require_once(__DIR__ . '/../connection.php');
// $sUsers = file_get_contents(__DIR__ . '/../data/users.json');

$sql = "SELECT tuser.cEmail, tuser.cUsername FROM tuser";

$statement = $connection->prepare($sql);

// $emailInput = $_POST['inputEmail'];

if ($_POST) {
  if ($statement->execute()) {
    $result = $statement->fetchAll();
    foreach ($result as $user) {
      if ($_POST['inputEmail'] == $user['cEmail'] || $_POST['inputEmail'] == $user['cUsername']) {
        echo "1";
        $connection = null;
        exit;
      }
    }
  }
}

echo "0";
$connection = null;
exit;
