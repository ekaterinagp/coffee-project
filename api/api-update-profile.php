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
// NAMES
  if (empty($_POST['inputName'])) {
    sendErrorMessage('name is empty', __LINE__);
  }

  if (empty($_POST['inputLastName'])) {
    sendErrorMessage('name is empty', __LINE__);
  }
  if (strlen($_POST['inputName']) < 2 || strlen($_POST['inputName']) > 20) {
      sendErrorMessage('name is invalid', __LINE__);
  }

  if (strlen($_POST['inputLastName']) < 2 || strlen($_POST['inputLastName']) > 50) {
    sendErrorMessage('lastname is invald', __LINE__);
  }

  // PHONE
  if (empty($_POST['inputPhone'])) {
    sendErrorMessage('phone is empty', __LINE__);
  }

  if (strlen($_POST['inputPhone']) !== 8) {
    sendErrorMessage('phonenumber is invald', __LINE__);
  }

  if(!ctype_digit($_POST['inputPhone'])){
    sendErrorMessage('phonenumber is invald', __LINE__);
  }

  // ADDRESS

  if (empty($_POST['inputAddress'])) {
    sendErrorMessage('address is empty', __LINE__);
  }

  if (strlen($_POST['inputLoginName']) > 12 ||strlen($_POST['inputLoginName']) > 255) {
    sendErrorMessage('email is empty', __LINE__);
  }

  // CITY

  if (empty($_POST['cityInput'])) {
      sendErrorMessage('city is empty', __LINE__);
  }

  if(!ctype_digit($_POST['cityInput'])){
      sendErrorMessage('city is invalid', __LINE__);
  }

  //EMAIL
  if(empty($_POST['inputEmail'])){
    sendErrorMessage('variable email [txtEmail] is missing',__LINE__);
  }

  if(!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)){ 
    sendErrorMessage('email is not valid', __LINE__);
  }

  // USERNAME 
  if (empty($_POST['inputLoginName'])) {
      sendErrorMessage('username is empty', __LINE__);
  }

  if (strlen($_POST['inputLoginName']) > 8 ||strlen($_POST['inputLoginName']) > 30) {
    sendErrorMessage('username is invalid', __LINE__);
  }

  // PASSWORD
  // if (empty($_POST['inputPassword'])) {
  //     sendErrorMessage('password is empty', __LINE__);
  //   }

  // if (strlen($_POST['inputPassword']) !== 8) {
  //     sendErrorMessage('password is invalid', __LINE__);
  //   }
    
    require_once(__DIR__.'/../connection.php');

    $sql = "UPDATE TUser SET cName=:name, cSurname=:lastName, cEmail=:email, cAddress=:address, nCityID =:cityID, cPhoneNo=:phone, cUsername=:username WHERE nUserID=:id"; // removed the password from the update statement
    $statement = $connection->prepare($sql);
    
    $data =[
        ':id' => $nUserID,
        ':name' => $_POST['inputName'],
        ':lastName' => $_POST['inputLastName'],
        ':email' => $_POST['inputEmail'],
        ':address' => $_POST['inputAddress'],
        ':cityID' => $_POST['cityInput'],
        ':phone' => $_POST['inputPhone'],
        ':username' => $_POST['inputLoginName'],
        // ':password' => $_POST['inputPassword']
        ];

        if($statement->execute($data)){
          echo 1;
          $connection = null;
          
          $_SESSION['user']['cName'] = $_POST['inputName'];
          $_SESSION['user']['cSurname'] = $_POST['inputLastName'];
          $_SESSION['user']['cEmail'] = $_POST['inputEmail'];
          $_SESSION['user']['cAddress'] = $_POST['inputAddress'];
          $_SESSION['user']['nCityID'] = $_POST['cityInput'];
          $_SESSION['user']['cPhoneNo'] = $_POST['inputPhone'];

          exit;

        }

        echo 0;
        $connection = null;
        exit;

    }

}