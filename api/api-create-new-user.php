<?php
if ($_POST) {

  if (empty($_POST['inputEmail'])) {
  }
  if (!filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['inputName'])) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['inputLastName'])) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (empty($_POST['inputPhone'])) {
    sendErrorMessage('phone is empty', __LINE__);
  }

  if (empty($_POST['inputAddress'])) {
    sendErrorMessage('address is empty', __LINE__);
  }

  if (strlen($_POST['inputAddress']) < 10) {
    sendErrorMessage('must be more than 10 characters', __LINE__);
  
  }

  if (empty($_POST['inputLoginName'])) {
    sendErrorMessage('login is empty', __LINE__);
  }

  if (strlen($_POST['inputLoginName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputLoginName']) > 12) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (strlen($_POST['inputLastName']) < 2) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputLastName']) > 20) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (empty($_POST['password_1'])) {
    sendErrorMessage('email is empty', __LINE__);
  }
  if (strlen($_POST['inputPhone']) !== 8) {
    sendErrorMessage('phone must be 8 characters', __LINE__);
  }

  if (strlen($_POST['password_1']) !== 8) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (empty($_POST['password_2'])) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (empty($_POST['cityInput'])) {
    sendErrorMessage('city is empty', __LINE__);
  }
  if (strlen($_POST['password_2']) !== 8) {
    sendErrorMessage('email is empty', __LINE__);
  }

  if (strlen($_POST['password_1']) != strlen($_POST['password_2'])) {
    sendErrorMessage('passwords do not match', __LINE__);
  }

  require_once(__DIR__ . '/../connection.php');
  require_once(__DIR__ . '/../components/functions.php');

  $sql = "INSERT INTO tuser(cName, cSurname, cEmail, cUserName, cPassword, cAddress, nCityID, cPhoneNo) VALUES (:name, :surname, :email, :username, :password, :address, :cityID, :phone)";

  $statement = $connection->prepare($sql);

  $data = [
    ':name' => $_POST['inputName'],
    ':surname' => $_POST['inputLastName'],
    ':email' => $_POST['inputEmail'],
    ':username' => $_POST['inputLoginName'],
    ':password' => $_POST['password_1'],
    ':address' => $_POST['inputAddress'],
    ':phone' => $_POST['inputPhone'],
    ':cityID' => $_POST['cityInput']
  ];

  if ($statement->execute($data)) {
  echo '{"status":1, "message":"New user created"}';
  
}

$connection = null;
exit;

}
