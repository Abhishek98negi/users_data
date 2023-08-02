<?php
    session_start();
    include('connection.php');
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
       
        if(empty($email) || empty($password)){
            echo "Please fill all the fields!";
        }
        else{
            $query = "select * from all_users where email = '$email' limit 1";
            $result = mysqli_query($con,$query);
            
            if($result && mysqli_num_rows($result)>0){
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['password'] === $password){
                    $_SESSION['id'] = $user_data['id'];
                    header("Location: logged_in.php");
                    die;    
                } 
            }
            echo "Wrong email or password"; 
            
        }
        
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>  

    <div class="main-div">
        <h1>Login</h1>

        <form action="login.php" method="post">
            <input type="email" name="email" class="input" placeholder="email..." required>
            <br>
            <input type="password" name="password" class="input" placeholder="password.." required>
            <br>
            <input type="submit" value="Login" class="button">

        </form>
        <h3>new user?</h3>        
        <button class="button"><a href="signup.php">Sign up</a></button>
    </div>
</body>
</html>