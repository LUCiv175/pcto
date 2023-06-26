<?php
    include("../conn.php");
    session_start();
    
    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sito">
        <h1>Home</h1>
        <p>Benvenuto <?php echo $_SESSION['username']; ?></p>
        
        <button><a href="updateMarche.php">Modifica Marche</a></button>
        <button><a href="updateModelli.php">Modifica Modelli</a></button>
        <form action="home.php" method="post">
        <input type="submit" name="logOut" value="Log out" id="logOut">
        </form>
    </div>
</body>
</html>
<?php
    if(isset($_POST['logOut'])) {
        session_destroy();
        header("Location: index.php");
    }
?>