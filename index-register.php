<?php include("connection.php") ?>
<php>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Web-Register</title>
    <link rel="stylesheet" href="style-register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="#" method="POST">
            <h1>Registration</h1>
            <div class="input-box">
                <div class="input-field">
                    <input type="text" placeholder="Full Name" required name="name">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Username" required name="user">
                    <i class='bx bxs-user'></i>
                </div>
            </div>
            <div class="input-box">
                <div class="input-field">
                    <input type="email" placeholder="Email" required name="email">
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-field">
                    <input type="text" placeholder="Phone" required name="phone">
                    <i class='bx bx-phone'></i>
                </div>
            </div>
            <div class="input-box">
                <div class="input-field">
                    <input type="password" placeholder="Set password" required name="pass">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-field">
                    <input type="password" placeholder="Confirm password" required name="conpassword">
                    <i class='bx bxs-lock-alt'></i>
                </div>
            </div>  
                <button type="submit" class="btn" name="register" value="submit">Register</button>
            
        </form>
</body>
</html>
</php>
<?php
//error_reporting(0);
if(isset($_POST["register"]))
{
    $name=$_POST["name"];
    $user=$_POST["user"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $pass=$_POST["pass"];
    $conpassword=$_POST["conpassword"];

    $query="INSERT INTO register(name,username,email,phone,password,conpassword) values('$name','$user','$email','$phone','$pass','$conpassword')";
    $data=mysqli_query($c,$query);
    if($data)
    {
        echo "Registered successfully";
    }
    else{
        echo "failed";
    }
}
?>