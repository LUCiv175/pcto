<?php
    include("../conn.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image" href="https://upload.wikimedia.org/wikipedia/it/2/23/Unione_Sportiva_Cremonese_logo.svg">
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sito">
        <h1>Login</h1>
        <form action="index.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
<?php
    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //hashing password
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            header("Location: home.php");
        } else {
            echo "<script>alert('Username o password errati')</script>";
       }
    }
?>  
