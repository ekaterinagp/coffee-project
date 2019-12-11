<?php

session_start();
require_once(__DIR__.'/../components/functions.php');

if(!$_SESSION){
    exit;
}

if($_SESSION){

    $jLoggedUser = $_SESSION['user'];
    $nUserID = $jLoggedUser['nUserID'];

    if($_POST){

        if (empty($_POST['inputIBAN'])) {
            sendErrorMessage('IBAN is empty', __LINE__);
          }

        if (empty($_POST['inputCCV'])) {
            sendErrorMessage('CCV is empty', __LINE__);
        }

        if (empty($_POST['inputExpiration'])) {
            sendErrorMessage('Expiration date is empty', __LINE__);
        }

        if (strlen($_POST['inputIBAN']) !== 18) {
            sendErrorMessage('IBAN is invalid', __LINE__);
        }

        if (strlen($_POST['inputCCV']) !== 3) {
            sendErrorMessage('CCV is invalid', __LINE__);
        }

        if (strlen($_POST['inputExpiration']) !== 4) {
            sendErrorMessage('Expiration is invalid', __LINE__);
        }

        if(!ctype_digit($_POST['inputIBAN'])){
            sendErrorMessage('phonenumber is invald', __LINE__);
          }
        if(!ctype_digit($_POST['inputCCV'])){
            sendErrorMessage('phonenumber is invald', __LINE__);
        }
          if(!ctype_digit($_POST['inputExpiration'])){
            sendErrorMessage('phonenumber is invald', __LINE__);
        }

        require_once(__DIR__.'/../connection.php');

        $sql = "INSERT INTO tCreditCard (cIBAN, cCCV, cExpiration, nUserID) VALUES (:iban, :ccv, :expiration, :id)";

        $statement = $connection->prepare($sql);
    
        $data =[
            ':id' => $nUserID,
            ':iban' => $_POST['inputIBAN'],
            ':ccv' => $_POST['inputCCV'],
            ':expiration' => $_POST['inputExpiration']
        ];

        if($statement->execute($data)){
        echo 1;
        }
        else{
            echo 0;
        }

    }

}