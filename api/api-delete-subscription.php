<?php
session_start();
require_once(__DIR__ . '/../components/functions.php');

if(!$_SESSION){
    sendErrorMessage('no user signed in', __LINE__);
}
if($_POST){
    if(empty($_POST['userSubscriptionID'])){
        sendErrorMessage('no id', __LINE__);
    }

  require_once(__DIR__ . '/../connection.php');

  $sql = "UPDATE tusersubscription SET dCancellation=CURRENT_TIMESTAMP() WHERE nUserSubscriptionID=:id";

  $statement = $connection->prepare($sql);  
  $data =[
    ':id' => $_POST['userSubscriptionID']
    ];
  if ($statement->execute($data)) {
    echo 1;
    $connection = null;
    exit;
  }
  else{
    echo 0;
    $connection = null;
    exit;
  }

}