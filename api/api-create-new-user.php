<?php
require_once(__DIR__ . '/../connection.php');

$statement = $connection->prepare("INSERT INTO tuser(cName, cSurname, cEmail, cUserName, cPassword, cAddress, nCityID, cPhoneNo) VALUES (:name, :surname, :email, :username, :password, :address, :regionID)");

if ($_POST) {
  if (empty($_POST['inputEmail'])) {
    return;
  }
  if (!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (empty($_POST['inputName'])) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (strlen($_POST['inputName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (strlen($_POST['inputName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (empty($_POST['inputLastName'])) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }

  if (empty($_POST['inputAddress'])) {
    sendErrorMessage('address is empty', __LINE__);
    return;
  }

  if (strlen($_POST['inputAddress']) > 12) {
    sendErrorMessage('must be more than 12 characters', __LINE__);
    return;
  }

  if (empty($_POST['inputLoginName'])) {
    sendErrorMessage('login is empty', __LINE__);
    return;
  }

  if (strlen($_POST['inputLoginName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (strlen($_POST['inputLoginName']) > 12) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }

  if (strlen($_POST['inputLastName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (strlen($_POST['inputLastName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (empty($_POST['password_1'])) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }
  if (strlen($_POST['password_1']) !== 8) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }

  if (empty($_POST['password_2'])) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }

  if (empty($_POST['regionsInput'])) {
    sendErrorMessage('region is empty', __LINE__);
    return;
  }
  if (strlen($_POST['password_2']) !== 8) {
    sendErrorMessage('email is empty', __LINE__);
    return;
  }

  if (strlen($_POST['password_1']) != strlen($_POST['password_2'])) {
    sendErrorMessage('passwords do not match', __LINE__);
    return;
  }

  $data = [
    'name' => $_POST['inputName'],
    'surname' => $_POST['inputLastName'],
    'email' => $_POST['inputEmail'],
    'username' => $_POST['inputLoginName'],
    'password' => $_POST['password_1'],
    'address' => $_POST['inputAddress'],
    'regionID' => $_POST['regionsInput']
  ];
  $stmt->execute($data);

  echo '{"status":1, "message":"New user created"}';
}
