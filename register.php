<?php
include "db.php";

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "INSERT INTO users (name, email, password) 
            VALUES ('$name', '$email', '$password')";

    if(mysqli_query($conn, $sql)) {
               header("Location:login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet"
     href="style.css">
</head>
<body>
<div class="container">
<h2>User Registration</h2>

<form action="" method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>

    <button type="submit" name="submit">Register</button>
</form>

</body>
</html>