<?php
require_once(__DIR__.'/../connection.php');
require_once(__DIR__.'/../components/functions.php');

$id = $_POST['id'];

$sql = "UPDATE tproduct SET nStock=:stock WHERE nProductID=:id";
$statement = $connection->prepare($sql);

if($_POST){
    if(empty($_POST['updateStock'])){
        sendErrorMessage('Stock missing', __LINE__);
    }
    if(empty($_POST['id'])){
        sendErrorMessage('no id', __LINE__);
    }
    
    $data =[
        ':stock' => $_POST['updateStock'],
        ':id' => $_POST['id']
    ];
    
    if($statement->execute($data)){
        echo '{"status":1, "message":"stock successfully updated"}';
    }
}
