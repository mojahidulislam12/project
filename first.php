<?php 
include 'config.php';
if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $pass=mysqli_real_escape_string($conn,md5($_POST['password']));
    $cpass=mysqli_real_escape_string($conn,md5($_POST['cpassword']));
    $image=$_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='uploaded_img/'.$image;

    $select=mysqli_query($conn,"SELECT * FROM `users2` WHERE email='$email' AND password = '$pass'") or die('Query failed');

    if(mysqli_num_rows( $select) > 0){
        $message[]='user already exist';
    }else{
        if( $pass != $cpass ){
        $message[]='confirm password not matched';
    }else if($image_size > 2000000){
        $message[]='image size is too large';
    }else{
        $insert=mysqli_query($conn,"INSERT INTO `users2`(name,email,password,image) VALUES('$name','$email','$pass','$image')") or die('query failed');
        if($insert){
            move_uploaded_file($image_tmp_name,$image_folder);
            $message[]='Registration is successfully';
            header('location:login.php');
        }else{
            $message[]='Registration falied'; 
        }
    }
}

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h3 class="text">Registration now</h3>
    <div class="form-container">
    <?php 
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
        }
    } 
    ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" id="" placeholder="Enter name" class="box" required>
            <input type="email" name="email" id="" placeholder="Enter email" class="box" required>
            <input type="password" name="password" id="" placeholder="Enter password" class="box" required>
            <input type="password" name="cpassword" id="" placeholder="Enter cpassword" class="box" required>
            <input type="file" class="box" name="image" id="" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" name="submit" id="" value="Submit" class="btn">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>