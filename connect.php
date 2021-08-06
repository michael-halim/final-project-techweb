<?php
    session_start();
    $host = 'localhost'; //IP MySQL nya dimana
    $db = 'proyek_tekweb';
    $user = 'root';
    $pw = '';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset:$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //data dikembalikan dalam bentuk objek bukan dalam bentuk array
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try{
        $pdo = new PDO($dsn , $user , $pw , $options);
    }
    catch(\PDOException $e){
        throw new \PDOException($e->getMessage(),(int)$e->getCode());
    }
?>