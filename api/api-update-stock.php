<?php


if($_POST){

    if(empty($_POST['updateStock'])){
        sendErrorMessage('Stock missing', __LINE__);
    }
    if(empty($_POST['id'])){
        sendErrorMessage('no id', __LINE__);
    }
    if(!ctype_digit($_POST['updateStock'])){
        sendErrorMessage('not a number', __LINE__);
    }

    $id = $_POST['id'];

    require_once(__DIR__.'/../connection.php');
    require_once(__DIR__.'/../components/functions.php');

    $sql = "UPDATE tproduct SET nStock=:stock WHERE nProductID=:id";
    $statement = $connection->prepare($sql);
    
    $data =[
        ':stock' => $_POST['updateStock'],
        ':id' => $_POST['id']
    ];
    
    if($statement->execute($data)){
        echo '{"status":1, "message":"stock successfully updated"}';
        $connection = null;
        exit;
    }

    echo 0;
    $connection = null;
    exit;
}
