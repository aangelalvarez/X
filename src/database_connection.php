<?php

    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'x';

    try {
        $connection = new PDO("mysql:host = $server; dbname=$database", $username, $password);
    } catch (PDOException $e) {
        die('Connection error' .$e->getMessage());
    }

?>