<?php
    include("../conn.php");
    session_start();
    
    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    $modelli = [];
    $query = "SELECT nome, modello, modelli.id_marca, targa, modelli.id FROM Marche inner join modelli on Marche.id=modelli.id_marca left join car on car.id_modello=modelli.id ORDER by nome, modello";
    $result = mysqli_query($conn, $query);
    foreach($result as $row) {
        $modelli[] = $row;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image" href="https://www.lagazzettadelmezzogiorno.it/resizer/-1/-1/true/1591518157892.png--.png?1591518158000">
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sito">
        <h1>Modifica Modelli</h1>
        <button id="home1"><a href="home.php">Home</a></button>
        <form action="updateModelli.php" method="post">
            <label for="marca">Marca</label>
            <select name="marca" id="marca">
                <?php
                    $rowPrec = [];
                    foreach($modelli as $row) {
                        if(empty($rowPrec) || !($rowPrec['nome'] == $row['nome'])) {
                            echo "<option value='".$row['id_marca']."'>".$row['nome']."</option>";
                            $rowPrec = $row;
                        }
                    }
                ?>
            </select>
            <label for="modello">Modello</label>
            <input type="text" name="modello" id="modello" required>
            <input type="submit" name="addModello" value="Aggiungi">
        </form>
        <?php
            if(isset($_GET['edit'])) {
                $id = $_GET['edit'];
                foreach($modelli as $row) {
                    if($row['id'] == $id) {
                        $modello = $row['modello'];
                    }
                }
                echo "<div class='edit'>";
                echo "<form action='updateModelli.php' method='post'>";
                echo "<input type='text' name='modello' value='".$modello."' required>";
                echo "<input type='hidden' name='id' value='".$id."'>";
                echo "<input type='submit' name='update' value='Modifica'>";
                echo "</form>";
                echo "</div>";
            }
        ?>
        <form action="updateModelli.php" method="post">
        <input type="submit" name="logOut" value="Log out" id="logOut1">
        </form>
        <form action="updateModelli.php" method="post">
            <label>Filtra per marca</label>
            <input type="text" name="filter" id="filter">
            <input type="submit" name="submitFilter" value="Filtra" id="filterSub">
        </form>
        <table>
            <tr>
                <th>Marca</th>
                <th>Modello</th>
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
            <?php
                if(isset($_GET['filter'])){
                    $filter = $_GET['filter'];
                }
                else
                    $filter = "*";
                $precRow = [];
                if($filter=='*'){
                    foreach($modelli as $row) {
                        if($row['modello']!='--Modello non presente--' && (empty($precRow) || $precRow['id']!= $row['id'])){
                            echo "<tr>";
                            echo "<td>".$row['nome']."</td>";
                            echo "<td>".$row['modello']."</td>";
                            echo "<td><a href='updateModelli.php?edit=".$row['id']."'>Modifica</a></td>";
                            if($row['targa'] == NULL){
                                echo "<td><a href='updateModelli.php?delete=".$row['id']."'>Elimina</a></td>";
                            }else
                                echo "<td><a href='updateModelli.php?delete=-1'>Elimina</a></td>";
                            echo "</tr>";
                        }
                        $precRow = $row;
                    }
                }
                else{
                    foreach($modelli as $row) {
                        if($row['modello']!='--Modello non presente--' && (empty($precRow) || $precRow['id']!= $row['id']) && ($row['nome']==$filter || str_contains(strtolower($row['nome']), strtolower($filter)))){
                            echo "<tr>";
                            echo "<td>".$row['nome']."</td>";
                            echo "<td>".$row['modello']."</td>";
                            echo "<td><a href='updateModelli.php?edit=".$row['id']."'>Modifica</a></td>";
                            if($row['targa'] == NULL){
                                echo "<td><a href='updateModelli.php?delete=".$row['id']."'>Elimina</a></td>";
                            }else
                                echo "<td><a href='updateModelli.php?delete=-1'>Elimina</a></td>";
                            echo "</tr>";
                        }
                        $precRow = $row;
                    }
                }
                
            ?>
        </table>
        <button><a href="home.php">Home</a></button>
            <form action="updateModelli.php" method="post">
            <input type="submit" name="logOut" value="Log out" id="logOut">
            </form>
    </div>
</body>
</html>
<?php
    if(isset($_POST['addModello'])) {
        $marca = $_POST['marca'];
        $modello = $_POST['modello'];
        $query = "INSERT INTO modelli (id_marca, modello) VALUES ('$marca', '$modello')";
        mysqli_query($conn, $query);
        echo "<script>window.location.href='updateModelli.php';</script>";
    }
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        if($id == -1){
            echo "<script>alert('Impossibile eliminare il modello, è presente almeno un veicolo di questo modello!');</script>";
            echo "<script>window.location.href='updateModelli.php';</script>";
        }
        else{
            $query = "DELETE FROM modelli WHERE id='$id'";
            mysqli_query($conn, $query);
        }  
        echo "<script>window.location.href='updateModelli.php';</script>";
    }
    if(isset($_POST['logOut'])) {
        session_destroy();
        header("Location: index.php");
    }
    if(isset($_POST['update'])) {
        $id = $_POST['id'];
        $modello = $_POST['modello'];
        $query = "UPDATE modelli SET modello='$modello' WHERE id='$id'";
        mysqli_query($conn, $query);
        echo "<script>window.location.href='updateModelli.php';</script>";
    }
    if(isset($_POST['submitFilter'])) {
        $filter = $_POST['filter'];
        echo "<script>console.log('".$filter."');</script>";
        echo "<script>window.location.href='updateModelli.php?filter=".$filter."';</script>";
    }
?>
