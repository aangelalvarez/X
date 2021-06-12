<?php
session_start();
require 'database_connection.php';
require 'input_validation.php';
require 'session.php';

$passwordErr = $message = $Errmessage = '';



if($_SERVER['REQUEST_METHOD'] == "POST"){

# validate the password
if(empty($_POST['password'])){
    $passwordErr = 'Password is required';
} else {
    if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password'])){
        $passwordErr = 'Invalid password format';
    } else {$password = validateInput($_POST['password']);}
}

# if the name is valid, this code will update the name in the DataBase
if (!empty($password)){
    $sql = "UPDATE users SET password =:password WHERE ID =:ID";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':password', $password);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $statement->bindParam(':ID', $user['ID']);
    
    # this condition shows if the program was able to send the information to 
    # the database
    if($statement->execute()) {
        $message = 'Password changed successfuly';
    } else {
        $Errmessage = 'Error changing password';
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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

        <?php if (!empty($passwordErr)): ?>
        <p class="errmsg"><?= $passwordErr?></p>
        <?php endif; ?>

        <div id="logo">
            <p>x</p>
        </div>
        <h1 style="margin-bottom:30px; margin-top:80px;">Change your password</h1>
        <form action="change_password.php" method="POST">
            <input type="text" name="password" placeholder="New Password"><br>
            <input type="submit" value="Change"><br>
            <a class="bottomlink" href="index.php">Return</a>
        </form>
    </section>

    

    
</body>
</html>