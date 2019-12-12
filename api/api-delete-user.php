<?php

session_start();
require_once(__DIR__.'/../components/functions.php');

if(!$_SESSION){
    sendErrorMessage('no user signed in', __LINE__);
}

if($_SESSION){
    $userID = $_SESSION['user']['nUserID'];

    require_once(__DIR__ . '/../connection.php');

    $sql = "UPDATE tUser SET dDeleteUser=CURRENT_TIMESTAMP() WHERE nUserId=:id";
    
      $statement = $connection->prepare($sql);  
      $data =[
        ':id' => $userID
      ];

      if ($statement->execute($data)) {
        echo 1;
        $connection = null;
        session_destroy();
        exit;
      }
      else{
        echo 0;
        $connection = null;
        exit;
      }  

    
}