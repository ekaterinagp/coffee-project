<?php

session_start();

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
            exit;
          }

        if (empty($_POST['inputLastName'])) {
            sendErrorMessage('name is empty', __LINE__);
            exit;
        }
        if (strlen($_POST['inputName']) < 2 || strlen($_POST['inputName']) > 20) {
            sendErrorMessage('name is invalid', __LINE__);
            exit;
        }

        if (strlen($_POST['inputLastName']) < 2 || strlen($_POST['inputLastName']) > 50) {
            sendErrorMessage('lastname is invald', __LINE__);
            exit;
        }

// PHONE

// if (empty($_POST['inputPhone'])) {
//     sendErrorMessage('phone is empty', __LINE__);
//     exit;
//   }

// if (strlen($_POST['inputPhone']) !== 8) {
//     sendErrorMessage('phonenumber is invald', __LINE__);
//     exit;
// }

// ADDRESS

//   if (empty($_POST['inputAddress'])) {
//     sendErrorMessage('address is empty', __LINE__);
//     exit;
//   }

//   if (strlen($_POST['inputLoginName']) > 12 ||strlen($_POST['inputLoginName']) > 255) {
//     sendErrorMessage('email is empty', __LINE__);
//     exit;
//   }

// CITY

// if (empty($_POST['cityInput'])) {
//     sendErrorMessage('city is empty', __LINE__);
//     exit;
//   }

//EMAIL

// if(empty($_POST['inputEmail'])){
//     sendErrorMessage('variable email [txtEmail] is missing',__LINE__);
//     exit;
//  }

// if(!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)){ 
//     sendErrorMessage('email is not valid', __LINE__);
//     exit;
// }

// USERNAME 

// if (empty($_POST['inputLoginName'])) {
//     sendErrorMessage('username is empty', __LINE__);
//     exit;
//   }

//   if (strlen($_POST['inputLoginName']) > 8 ||strlen($_POST['inputLoginName']) > 30) {
//     sendErrorMessage('username is invalid', __LINE__);
//     exit;
//   }

// PASSWORD

// if (empty($_POST['password'])) {
//     sendErrorMessage('password is empty', __LINE__);
//     exit;
//   }

// if (strlen($_POST['password']) !== 8) {
//     sendErrorMessage('password is invalid', __LINE__);
//     exit;
//   }
    
    require_once(__DIR__.'/../connection.php');
    require_once(__DIR__.'/../components/functions.php');

// password & username

    $sql = "UPDATE TUser SET cName=:name, cSurname=:lastName WHERE nUserID=:id";
    // $sql = "UPDATE TUser SET cName=:name, cSurname=:lastName, cEmail=:email, cAddress=:address, cPhone=:phone, cUsername=:username, cPassword=:password WHERE nUserID=:id";
    $statement = $connection->prepare($sql);
    echo json_encode($_POST);
    
    $data =[
        ':name' => $_POST['inputName'],
        ':lastName' => $_POST['inputLastName']

        // ':email' => $_POST['inputEmail'],
        // ':address' => $_POST['inputAddress'],
        // ':cityID' => $_POST['cityInput'],
        // ':phone' => $_POST['inputPhone'],

        // ':username' => $_POST['inputUsername'],
        // ':password' => $_POST['inputPassword']
        ];

        if($statement->execute($data)){
        echo '{"status":1, "message":"price successfully updated"}';
        }

    }

}