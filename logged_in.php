<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $user_data = check_login($con); 

    $id = $user_data['id'];
    $username = $user_data['username'];
    $email = $user_data['email'];
    $password = $user_data['password'];
    $phone="";
    $about="";
    $address="";
    $first_time_login = true;

    $sql = "SELECT * FROM `single_user` WHERE `user_id`='$id'";
    $result = $con->query($sql); 

    if ($result->num_rows > 0) {        
        $first_time_login = false;
        while ($row = $result->fetch_assoc()) {
            $phone = $row['phone'];
            $about = $row['about'];
            $address = $row['address'];
        }
    }

    if(isset($_POST['update'])){
        $updated_password = $_POST['password'];
        $phone = $_POST['phone'];
        $about = $_POST['about'];
        $address = $_POST['address'];
        
        if($password != $updated_password){
            $password = $updated_password;
            $sql = "UPDATE `all_users` SET `password`='$password' WHERE `id`='$id'"; 
            $result = $con->query($sql); 
    
            if ($result == false) {
                echo "Error:" . $sql . "<br>" . $con->error;
            }
        }

        if($first_time_login){
            $sql = "INSERT INTO `single_user`(`phone`, `about`, `address`, `user_id`) VALUES ('$phone','$about','$address','$id')";
            $result = $con->query($sql);

            if ($result == TRUE) {
            echo "New records created successfully.";
            }else{
            echo "Error:". $sql . "<br>". $con->error;
            } 
            
             
        }
        else{

            $sql = "UPDATE `single_user` SET `phone`='$phone',`about`='$about',`address`='$address' WHERE `user_id`='$id'"; 
            $result = $con->query($sql); 
    
            if ($result == TRUE) {
                echo "Record updated successfully.";
            }else{
                echo "Error:" . $sql . "<br>" . $con->error;
            }
             
        }
        
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location: login.php");
    }
    
    if(isset($_POST['delete'])){
        $sql = "DELETE FROM `single_user` WHERE `user_id`='$id'";
        $result = $con->query($sql);
        if ($result == False) {
           echo "Error:" . $sql . "<br>" . $con->error;
        }

        $sql = "DELETE FROM `all_users` WHERE `id`='$id'";
        $result = $con->query($sql);
        if ($result == False) {
           echo "Error:" . $sql . "<br>" . $con->error;
        }

        header("Location: login.php");
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>logged in</title>
</head>
<body>
    <h1 id="heading">Hello <?php echo $user_data['username'] ?></h1>
    
    <form action="" method="post">
        <p>Username <?php echo $username; ?></p>
        <p>Email <?php echo $email; ?></p>
        Password <input type="text" name="password" value="<?php echo $password; ?>" >
        <br>
        Phone <input type="text" name="phone" value="<?php echo $phone; ?>">
        <br>
        About you <input type="textarea" name="about" value="<?php echo $about; ?>">
        <br>
        Address <input type="text" name="address" value="<?php echo $address; ?>">
        <br>
        <input type="submit" value="Update" name="update">
        <input type="submit" value="Logout" name="logout">
        <input type="submit" value="delete my account" name="delete">

    </form>
    

</body>
</html>