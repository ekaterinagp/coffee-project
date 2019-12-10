<?php

session_start();
require_once(__DIR__.'/../components/functions.php');

if(!$_SESSION){
    exit;
}

if($_SESSION){

    $jLoggedUser = $_SESSION['user'];
    $nUserID = $jLoggedUser['nUserID'];
    echo $nUserID;

    if($_POST){
        echo 'posted';

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

    }

}