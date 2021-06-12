<?php
    require 'database_connection.php';
    require 'input_validation.php';
    
    $message = $emailErr = $passwordErr = $nameErr = $invalidname = '';
    $invalidemail = $invalidpassword = $name = $email = $password = $Errmessage = '';
    
 
    # the code is executed if there is entered input
    # if no input is detected, the required fields will be shown at the top
    if($_SERVER['REQUEST_METHOD'] == "POST"){
       
        # validate the name 
        if(empty($_POST['name'])){
            $nameErr = 'Name is required';
        } else {
            if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST['name'])){
                $nameErr = "Invalid name format";
            } else {$name = validateInput($_POST['name']);}
        }

        # validate the e-mail
        if (empty($_POST['email'])){
            $emailErr = 'E-mail is required';
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid E-mail format";
            } else {$email = validateInput($_POST['email']);}
        }
        
        # validate the password
        if(empty($_POST['password'])){
            $passwordErr = 'Password is required';
        } else {
            if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password'])){
                $passwordErr = 'Invalid password format';
            } else {$password = validateInput($_POST['password']);}
        }

        # if all the fields are completed AND validated, then the code below will
        # send the information to the database

    }
    if (!empty($name) && !empty($email) && !empty($password)){
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $statement->bindParam(':password', $password);
        
        # this condition shows if the program was able to send the information to 
        # the database
        if($statement->execute()) {
            $message = 'Account created successfuly';
        } else {
            $Errmessage = 'Error creating your account';
        }
        }
    
    
    

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>X</title>
<style>

</style>

</head>
<body>
    <section class="box">
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

        <?php if (!empty($emailErr)): ?>
        <p class="errmsg"><?= $emailErr?></p>
        <?php endif; ?>

        <?php if (!empty($passwordErr)): ?>
        <p class="errmsg"><?= $passwordErr?></p>
        <?php endif; ?>

        
        <div id="logo">
            <p>x</p>
        </div>
        <h1 style="margin-bottom:30px;">Create your account</h1>
        <form action="signup.php" method="POST">
            <input type="text" name="name" placeholder="Name"><br> 
            <input type="text" name="email" placeholder="E-mail"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input style="margin-bottom:15px" type="submit" value="Sign up"><br>
            <p>Already have an account? <a class="bottomlink" href="index.php">Log in</a></span>
        </form>
    </section>
</body>
</html>