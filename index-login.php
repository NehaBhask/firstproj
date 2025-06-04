<?php
session_start();
include("connection.php");
if(isset($_POST['login']))
{
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $sql="SELECT * FROM register WHERE username='$user' AND conpassword='$pass'";
    $d=mysqli_query($c,$sql);
    $row=mysqli_fetch_array($d,MYSQLI_ASSOC);
    $count=mysqli_num_rows($d);
     
    if($count==1)
    {
        $s="SELECT user_id from register WHERE username='$user' AND conpassword='$pass' ";
        $r=mysqli_query($c,$s);
        $col=mysqli_fetch_assoc($r);
        $_SESSION['user_id'] = $col['user_id'];
        header("location:dashboard.php");
        
    }
    else{
        echo "<script>
        alert('Login failed.Wrong username or password');
        </script>";
       // window.location.href='index-login.php' ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Web-Login</title>
    <link rel="stylesheet" href="style-login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="index-login.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" required name="user">
                <i class="bx bxs-user"></i>
                
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" required name="pass">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn" value="submit" name="login">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="index-register.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
</php>
