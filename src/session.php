<?php
    #create a session and keep it until the user logs out
    require 'database_connection.php';
    if(isset($_SESSION['user_ID'])){
        $records = $connection->prepare('SELECT ID, name, email, password FROM users WHERE ID = :ID');
        $records->bindParam(':ID', $_SESSION['user_ID']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $user = null;
        if (count($results) > 0){
            $user = $results;
        }
    }
?>