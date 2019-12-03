<?php
require_once(__DIR__.'/../connection.php');

$id = $_POST['id'];
$stmt = $connection->prepare("UPDATE tproduct SET nSTock=:stock WHERE nProductID=:id");


if($_POST){
    if(empty($_POST['updateStock'])){
        sendError('Stock missing', __LINE__);
    }
    if(empty($_POST['id'])){
        sendError('no id', __LINE__);
    }


    
    $data =[
        'stock' => $_POST['updateStock'],
        'id' => $_POST['id']
        ];
    $stmt->execute($data);

    echo '{"status":1, "message":"stock successfully updated"}';
}





/****************/
function sendError($message, $line){
    echo '{"status":0, "message": '.$message.', "line":'.$line.'}';
    exit;
}