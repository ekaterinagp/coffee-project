<?php

session_start();
require_once(__DIR__.'/../components/functions.php');

if(!$_SESSION){
    sendErrorMessage('No user', __LINE__);
}
if($_SESSION){

        $jLoggedUser = $_SESSION['user'];
        $nUserID = $jLoggedUser['nUserID'];

    if($_POST){
        if(empty($_POST['taxPercentage'])){
            sendErrorMessage('No tax', __LINE__);
        }
        if(empty($_POST['productID'])){
            sendErrorMessage('No product', __LINE__);
        }
        if(empty($_POST['creditCardID'])){
            sendErrorMessage('No credit card', __LINE__);
        }
        if(!ctype_digit($_POST['creditCardID']) && 
        !ctype_digit($_POST['productID']) && 
        !ctype_digit($_POST['taxPercentage'])){
            sendErrorMessage('id not a number', __LINE__);
        }
        require_once(__DIR__.'/../connection.php');
        $sql = 'CALL purchaseSubscriptionTransaction(:userID, :subscriptionID, :creditCardID, :taxPercentage)';
        $statement = $connection->prepare($sql);
        $data =[
            ':subscriptionID' => $_POST['productID'],
            ':creditCardID' => $_POST['creditCardID'],
            ':userID' => $nUserID,
            ':taxPercentage' => $_POST['taxPercentage']
        ];

        if($statement->execute($data)){
            echo 1;
            }
        else{
            echo 0;
         
        }
    }
}
$connection = null;
// exit;