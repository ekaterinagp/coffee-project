<?php
require_once(__DIR__.'/../components/functions.php');

if($_POST){

    if(empty($_POST['updatePrice'])){
        sendErrorMessage('Price missing', __LINE__);
    }
    
    if(empty($_POST['id'])){
        sendErrorMessage('no id', __LINE__);
    }
    if(!ctype_digit($_POST['updatePrice'])){
        sendErrorMessage('not a number', __LINE__);
    }

    $id = $_POST['id'];
    
    require_once(__DIR__.'/../connection.php');

    $sql = "UPDATE tproduct SET nPrice=:price WHERE nProductID=:id";
    $statement = $connection->prepare($sql);
    
    $data =[
        ':price' => $_POST['updatePrice'],
        ':id' => $_POST['id']
        ];

    if($statement->execute($data)){
        echo '{"status":1, "message":"price successfully updated"}';
        $connection = null;
        exit;
    }else{
        
        echo 0;
        $connection = null;
    }

   
}
