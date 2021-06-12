<?php
    session_start();
    require 'database_connection.php';
    require 'input_validation.php';
    require 'session.php';
    

    $emailErr = $passwordErr = $email = $password = $Errmessage = '';
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
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
        # check if the information matches the DataBase records
        if (!empty($email) && !empty($password)) {   
            $records = $connection->prepare('SELECT ID, name, email, password FROM users WHERE email=:email');
            $records->bindParam(':email', $email);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

            $message = '';
                                                                                   
            if(count($results) > 0 && password_verify($password, $results['password'])){
                $_SESSION['user_ID'] = $results['ID'];
                header('Location: /X/');
            } else{
                $Errmessage = 'Error, incorrect e-mail or password';
            }
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
    .bottomlink {
        text-decoration: none;
        color:rgb(1, 138, 131);
        padding:5px;
        transition: 0.3s;
        border-radius: 3px;
    }
    .bottomlink:hover{
        background-color: rgb(2, 218, 207);
        color:white;
    }
    </style>
</head>
<body>
        <?php if (!empty($user)): ?>
            <a href="#" id="user"><?= $user['name']; ?></a><br>
            <a class="changename" href="change_name.php">Change Name</a>
            <a class="changepass" href="change_password.php">Change Password</a>
            <div id="topbar">
                <a href="logout.php" class="logout">Log out</a>
            </div>
        <?php else: ?>  

    <section class="box">
    <div id="margin"></div>
        
        <?php if (!empty($message)): ?>
        <p class="errmsg" ><?= $message?></p>
        <?php endif; ?>

        <?php if (!empty($Errmessage)): ?>
        <p class="errmsg" ><?= $Errmessage?></p>
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
        <h1 style="margin-bottom:30px;">Log into your account</h1>
        <form action="index.php" method="POST">
            <input type="text" name="email" placeholder="E-mail"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input style="margin-bottom:80px;" type="submit" value="Log in"><br>
            <p>New user? <a class="bottomlink" href="signup.php">Sign up</a></p>
        </form>
    </section>
    <?php endif; ?>
</body>
</html>