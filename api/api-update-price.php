<?php
require_once(__DIR__.'/../connection.php');

$id = $_POST['id'];
$stmt = $connection->prepare("UPDATE tproduct SET nPrice=:price WHERE nProductID=:id");


if($_POST){
    if(empty($_POST['updatePrice'])){
        sendError('Price missing', __LINE__);
    }
    // if(empty($_POST['updateStock'])){
    //     sendError('stock missing', __LINE__);
    // }
    if(empty($_POST['id'])){
        sendError('no id', __LINE__);
    }


    
    $data =[
        'price' => $_POST['updatePrice'],
        'id' => $_POST['id']
        ];
    $stmt->execute($data);

    echo '{"status":1, "message":"price successfully updated"}';
}





/****************/
function sendError($message, $line){
    echo '{"status":0, "message": '.$message.', "line":'.$line.'}';
    exit;
}