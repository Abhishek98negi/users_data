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
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="main-div">

        <h1>Your data</h1>
        
        <form action="" method="post">
            <div class="container">
                <h3 class="child1">Name</h3>
                <h3 class="child2"><?php echo $username; ?></h3>
            </div>
            <div class="container">
                <h3 class="child1">Email</h3>
                <h3 class="child2"><?php echo $email; ?></h3>
            </div>
            <div class="container">
                <h3 class="child1 child1-label">Password</h3>
                <input type="text" class="child2 child-input" name="password" value="<?php echo $password; ?>" >
            </div>
            <div class="container">
                <h3 class="child1 child1-label">Phone</h3> 
                <input type="text" class="child2 child-input" name="phone" value="<?php echo $phone; ?>">
            </div>
            <div class="container">
                <h3 class="child1 child1-label">Address</h3>
                <input type="text" class="child2 child-input" name="address" value="<?php echo $address; ?>">
            </div>
            <div class="container">
                <h3 class="child1 child1-label">About you</h3>
                <input type="text" class="child2 child-input" name="about" value="<?php echo $about; ?>">
            </div>
            
           


            <input class="button update" type="submit" value="Update" name="update">
            <input class="button" type="submit" value="Logout" name="logout">
            <br>
            <input class="button delete-acc" type="submit" value="Delete my account" name="delete">

        </form>
        
    </div>

</body>
</html>