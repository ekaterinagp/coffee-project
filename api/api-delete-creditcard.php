<?php

session_start();
require_once(__DIR__.'/../components/functions.php');

if(!$_SESSION){
    exit;
}

if($_POST){

    require_once(__DIR__ . '/../connection.php');

    $sql = "UPDATE tcreditcard SET dDeleteCreditCard=CURRENT_TIMESTAMP() WHERE nCreditCardID=:id";
    
      $statement = $connection->prepare($sql);  
      $data =[
        ':id' => $_POST['nCreditCardID']
        ];

      if ($statement->execute($data)) {
        echo 1;
        $connection = null;
        exit;
      }

      echo 0;
      $connection = null;
      exit;
    
}