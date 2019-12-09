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
        // echo 'empty';
    }
    if (strlen($_POST['password']) !== 8) {
      sendErrorMessage('password is wrong length', __LINE__);
      return;
    }
  
  
  
    $statement = "SELECT * FROM tuser";
    $result = $connection->query($statement)->fetchAll();
    // var_dump($result);
    // $correctUser=null;
    $password = hash("sha224", $_POST['password']);
    $emailInput = $_POST['inputEmail'];
  
    foreach ($result as $user) {
      if ($password == $user["cPassword"] && ($emailInput == $user["cEmail"]  || $emailInput == $user['cUsername'])) {
        // echo "user found!";
        unset($user['cPassword']);
        $_SESSION['user'] = $user;
        echo '1';
        exit;
      }
    }
    // if ($emailInput == $user["cEmail"] && $password !== $user["cPassword"]) {
    //     echo "wrong password";
    //   }

  
    // if ($emailInput == !$user["cEmail"]) {
    //   //turn to frontendnormalvalidation
  
    //   echo "user with this email is not found";
    // }
  
  
    
  }
  echo '0';