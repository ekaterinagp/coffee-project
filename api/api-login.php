<?php
session_start();

  if ($_POST) {
    require_once(__DIR__.'/../connection.php');
    require_once(__DIR__.'/../components/functions.php');
  
    if (empty($_POST['inputEmail'])) {
    sendErrorMessage('email is empty', __LINE__);
    }
       if (empty($_POST['password'])) {
      sendErrorMessage('password is empty', __LINE__);
    }
    if (strlen($_POST['password']) !== 8) {
      sendErrorMessage('password is wrong length', __LINE__);
    }
  
    $sql = "SELECT * FROM tuser WHERE dDeleteUser IS NULL AND cPassword=:password AND cEmail = :email OR cUsername = :username";
    $statement = $connection->prepare($sql);

    $password = hash("sha224", $_POST['password']);
    $emailInput = $_POST['inputEmail'];

    $data = [
      ':password' => $password,
      ':email' => $emailInput,
      ':username' => $emailInput
    ];

    if($statement->execute($data)){
    $result = $statement->fetch();
        unset($result['cPassword']);
        $_SESSION['user'] = $result;
        echo '1';
        $connection = null;
        exit;
  }
}
  echo '0';
  $connection = null;
  exit;

  // <?php

// session_start();

//   if ($_POST) {
//     require_once(__DIR__.'/../connection.php');
//     require_once(__DIR__.'/../components/functions.php');
  
//     if (empty($_POST['inputEmail'])) {
//     sendErrorMessage('email is empty', __LINE__);
//     }
//        if (empty($_POST['password'])) {
//       sendErrorMessage('password is empty', __LINE__);
//     }
//     if (strlen($_POST['password']) !== 8) {
//       sendErrorMessage('password is wrong length', __LINE__);
//     }
  
//     $sql = "SELECT * FROM tuser WHERE dDeleteUser IS NULL";
//     $statement = $connection->prepare($sql);

//     if($statement->execute()){
//     $result = $statement->fetchAll();

//     $password = hash("sha224", $_POST['password']);
//     $emailInput = $_POST['inputEmail'];
  
//     foreach ($result as $user) {
//       if ($password == $user["cPassword"] && ($emailInput == $user["cEmail"]  || $emailInput == $user['cUsername'])) {
//         unset($user['cPassword']);
//         $_SESSION['user'] = $user;
//         echo '1';
//         $connection = null;
//         exit;
//       }
//     }
//   }
// }
//   echo '0';
//   $connection = null;
//   exit;