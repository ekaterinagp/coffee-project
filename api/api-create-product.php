<?php
require_once(__DIR__.'/../connection.php');

$stmt = $connection->prepare("INSERT INTO tproduct (cName, nPrice, nStock, nCoffeeTypeID) VALUES (:name, :price, :stock, :coffeetype)");
// $stmt= $connection->prepare($sql);
if($_POST){
    
    if(empty($_POST['newPrice'])){
        sendError('Price missing', __LINE__);
    }
    if(empty($_POST['newStock'])){
        sendError('stock missing', __LINE__);
    }
    if(empty($_POST['newName'])){
        sendError('name missing', __LINE__);
    }
    if(empty($_POST['newCoffeetype'])){
        sendError('coffetype missing', __LINE__);
    }


    $data =['name' => $_POST['newName'],
        'price' => $_POST['newPrice'],
        'stock' => $_POST['newStock'],
        'coffeetype' => $_POST['newCoffeetype']
        ];
    $stmt->execute($data);

    echo '{"status":1, "message":"Product successfully created"}';
}




/****************/
function sendError($message, $line){
    echo '{"status":0, "message": '.$message.', "line":'.$line.'}';
    exit;
}