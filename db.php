<?php

$host = '127.0.0.1';
$db = 'ProperPour';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // using 'mysql:connecting to the host; specifying dbname';

$username = 'root'; // default for xampp phpmyadmin mysql
$password = ''; // default for xampp phpmyadmin mysql
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$sql = "SELECT * FROM TUser";
//$connection = new PDO($dsn, $username, $password, $options); // PDO connection with own variable - the instance of the PDO
// new PDO() takes 4 parameters: $dsn (datasourcename), $username, $password, $options

// TEST IF CONNECTION IS SUCCEFUL WITH try catch


try{
    $connection = new PDO($dsn, $username, $password, $options);
    foreach ($connection->query($sql) as $row) {
      echo $row['cName'] . "\t";
        echo $row['cSurname'] . "\t";
    }
    

    if($stmt === false){
        die("Error executing the query");
        }
        

    
} catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode()); // throw me errors
}
