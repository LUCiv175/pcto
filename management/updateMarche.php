<?php
    include("../conn.php");
    session_start();
    
    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    }
    
    $marchew= [];
    $query = "SELECT * FROM car right join Marche on Marche.id = car.id_marca order by nome asc";
    $result = mysqli_query($conn, $query);
    foreach($result as $row) {
        $marche[] = $row;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image" href="https://upload.wikimedia.org/wikipedia/it/thumb/c/c7/US_Lecce.svg/1200px-US_Lecce.svg.png">
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sito">
        <h1>Modifica Marche</h1>
        <form action="updateMarche.php" method="post">
            <label for="marca">Marca</label>
            <input type="text" name="marca" id="marca" required>
            <input type="submit" name="add" value="Aggiungi">
        </form>
        <table>
            <tr>
                <th>Marca</th>
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
            <?php
                if(isset($_GET['edit'])) {
                    $id = $_GET['edit'];
                    foreach($marche as $row) {
                        if($row['id'] == $id) {
                            $marca = $row['nome'];
                        }
                    }
                    echo "<form action='updateMarche.php' method='post'>";
                    echo "<input type='text' name='marca' id='marca' value='".$marca."' required>";
                    echo "<input type='hidden' name='id' value='".$id."'>";
                    echo "<input type='submit' name='update' value='Modifica'>";
                    echo "</form>";
                }
                $precRow = [];
                foreach($marche as $row) {
                    if(empty($precRow) || !($precRow['nome'] == $row['nome'])) {
                        echo "<tr>";
                        echo "<td>".$row['nome']."</td>";
                        echo "<td><a href='updateMarche.php?edit=".$row['id']."'>Modifica</a></td>";
                        if($row['targa'] == NULL){
                            echo "<td><a href='updateMarche.php?delete=".$row['id']."'>Elimina</a></td>";
                        }else
                            echo "<td><a href='updateMarche.php?delete=-1'>Elimina</a></td>";
                        echo "</tr>";
                        $precRow = $row;
                    }
                    }
                

            ?>
        </table>
        <button><a href="home.php">Home</a></button>
        <form action="home.php" method="post">
        <input type="submit" name="logOut" value="Log out" id="logOut">
        </form>
</body>
</html>
<?php
    if(isset($_POST['add'])) {
        $marca = $_POST['marca'];
        $query = "INSERT INTO Marche (nome) VALUES ('$marca')";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "<script>alert('Aggiunto')</script>";
            echo "<script>window.location.href='updateMarche.php'</script>";
        } else {
            echo "<script>alert('Errore')</script>";
        }
    }
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        //var_dump($id);
        if($id == -1){
            echo "<script>alert('Impossibile eliminare la marca')</script>";
            echo "<script>window.location.href='updateMarche.php'</script>";
        }
        else {
            $query = "DELETE FROM Marche WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            if($result) {
                echo "<script>alert('Eliminato')</script>";
                echo "<script>window.location.href='updateMarche.php'</script>";
            } else {
                echo "<script>alert('Errore')</script>";
            }
        }   
    }
    
    if(isset($_POST['update'])) {
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $query = "UPDATE Marche SET nome = '$marca' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "<script>alert('Modificato')</script>";
            echo "<script>window.location.href='updateMarche.php'</script>";
        } else {
            echo "<script>alert('Errore')</script>";
        }
    }
    if(isset($_POST['logOut'])) {
        session_destroy();
        header("Location: index.php");
    }
    echo "</div>";
?>
