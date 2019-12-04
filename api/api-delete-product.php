<?php
require_once(__DIR__.'/../connection.php');


$stmt = $connection->prepare("UPDATE tproduct SET bActive=0 WHERE nProductID=:id");


if($_POST){
    $id = $_POST['id'];
    
    $data =[
        'id' => $_POST['id']
        ];
    $stmt->execute($data);

    echo '{"status":1, "message":"product successfully deleted"}';
}





/****************/
function sendError($message, $line){
    echo '{"status":0, "message": '.$message.', "line":'.$line.'}';
    exit;
}