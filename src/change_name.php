<?php
session_start();
require 'database_connection.php';
require 'input_validation.php';
require 'session.php';

$nameErr = $message = $Errmessage = '';



if($_SERVER['REQUEST_METHOD'] == "POST"){
 # validate the name 
 if(empty($_POST['name'])){
    $nameErr = 'Name is required';
} else {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST['name'])){
        $nameErr = "Invalid name format";
    } else {$name = validateInput($_POST['name']);}
}

# if the name is valid, this code will update the name in the DataBase
if (!empty($name)){
    $sql = "UPDATE users SET name =:name WHERE ID =:ID";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':ID', $user['ID']);
    
    # this condition shows if the program was able to send the information to 
    # the database
    if($statement->execute()) {
        $message = 'Name changed successfuly';
    } else {
        $Errmessage = 'Error changing name';
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change name</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="box" style="margin-bottom:30px;">
        <div id="margin"></div>

        <?php if (!empty($message)): ?>
        <p class="msg" ><?= $message?></p>
        <?php endif; ?>

        <?php if (!empty($Errmessage)): ?>
        <p class="errmsg" ><?= $Errmessage?></p>
        <?php endif; ?>

        <?php if (!empty($nameErr)): ?>
        <p class="errmsg"><?= $nameErr?></p>
        <?php endif; ?>

        <div id="logo">
            <p>x</p>
        </div>
        <h1 style="margin-bottom:30px; margin-top:80px;">Change your name</h1>
        <form action="change_name.php" method="POST">
            <input type="text" name="name" placeholder="New Name"><br>
            <input type="submit" value="Change"><br>
            <a class="bottomlink" href="index.php">Return</a>
        </form>
    </section>

    

    
</body>
</html>