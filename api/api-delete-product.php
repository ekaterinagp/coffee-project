<?php
if($_POST){
    require_once(__DIR__.'/../connection.php');
    require_once(__DIR__.'/../components/functions.php');

    $sql = "UPDATE tproduct SET bActive=0 WHERE nProductID=:id";
    $statement = $connection->prepare($sql);

    $id = $_POST[':id'];
    
    $data =[
        'id' => $_POST['id']
        ];

    if($statement->execute($data)){
        echo '{"status":1, "message":"product successfully deleted"}';
    }
}
