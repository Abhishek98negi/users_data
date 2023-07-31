<?php
    session_start();
    include('connection.php');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(empty($username) || empty($email) || empty($password)){
            echo "Please fill all the fields!";
        }
        else{
            $stmt = $con->prepare("SELECT * FROM all_users WHERE email=?");
            $stmt->execute([$email]); 
            $user = $stmt->fetch();
            if ($user) {
                echo "This email is used by another person. Kindly login or signup with another email.";
            } 
            else{
                $query = "insert into all_users (username,email,password) values ('$username','$email','$password')";
                mysqli_query($con,$query);
                
                $query = "select * from all_users where email = '$email' limit 1";
                $result = mysqli_query($con,$query);
                $user_data = mysqli_fetch_assoc($result);
                
                $_SESSION['id'] = $user_data['id'];
                header("Location: logged_in.php");
                die;
            }
            
        }
        
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
</head>
<body>
    <h1>Signup</h1>

    <form action="signup.php" method="post">
        <input type="text" name="username" placeholder="username..." required>
        <br>
        <input type="email" name="email" placeholder="email..." required>
        <br>
        <input type="password" name="password" placeholder="password.." required>
        <br>
        <input type="submit" value="signup">

    </form>
    <br>
    <button><a href="login.php">Login</a></button>


</body>
</html>