<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
 
    $servername = "";
        
    $username = "";
        
    $password = "";
        
    $dbname = "";
        
        
        
    // Connessione al database
        
    $conn = mysqli_connect($servername, $username, $password, $dbname);
        

        
    // Verifica della connessione
        
    if (!$conn) {
        
        die("Connessione al database fallita: " . mysqli_connect_error());
        
    }
  
?>

<!DOCTYPE html>
<html>

<head>
    <title>Autonoleggio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image" href="https://upload.wikimedia.org/wikipedia/it/thumb/e/ed/SSC_Napoli_2007.svg/1200px-SSC_Napoli_2007.svg.png">
</head>

<body>
    <div class="sito">
    <h1>Autonoleggio</h1>

    
    <form action="index.php" method="post" id="carInput">
        <label>Targa:</label>
        <input type="text" name="targa" required><br>
        <label>Marca:</label>
        <select name="marca" required>
            <option disabled selcted value>Marca...</option>
            <?php
                $sql = "SELECT * FROM Marche ";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row["id"] . "'>" . $row["nome"] . "</option>";
                }
            ?>
        </select>
        <label>Modello:</label>
        <input type="text" name="modello" required><br>
        <label>Numero Posti:</label>
        <input type="number" name="nPosti" required><br>
        <input type="submit" name="submitInserisci" value="Aggiungi Veicolo">
    </form>
    <form action="index.php" method="post">
        <!---<input type="text" name="Elimina" required><br>
        <input type="submit" name="submitElimina" value="Elimina" id="elimina">-->
    </form>
    <form action="index.php" method="post">
        <!-- search by targa
        <input type="text" name="Ricerca" required><br>
        <input type="submit" name="submitRicerca" value="Ricerca">-->
    </form>
    <!--show all cars
    <form action="index.php" method="post">
    <input type="submit" name="submitInventario" value="Mostra Inventario"></form>-->
    <script>
        let selezionaTutto = () =>{
            let checkAll = document.getElementById("checkAll");
            let check = document.getElementsByName("check[]");
            if(checkAll.checked){
                for(let i = 0; i < check.length; i++){
                    check[i].checked = true;
                }
            }else{
                for(let i = 0; i < check.length; i++){
                    check[i].checked = false;
                }
            }
        }
    </script>
    </body>
<?php
    // Esempio di UPDATE
    /*
    
    $sql = "UPDATE car SET delated = 1 WHERE targa = '$targa'";
    
    if (mysqli_query($conn, $sql)) {
    
        echo "Record aggiornato con successo";
    
    } else {
    
        echo "Errore nell'aggiornamento del record: " . mysqli_error($conn);
    
    }
    
     */
    /*
    
    // Esempio di SELECT
    
    $sql = "SELECT * FROM car where deleted = 0 ";
    
    $result = mysqli_query($conn, $sql);
    
     
    
    if (mysqli_num_rows($result) > 0) {
    
        while ($row = mysqli_fetch_assoc($result)) {
    
            echo "ID: " . $row["id"] . " - Targa: " . $row["targa"] . "<br>" . "Marca: " . $row["marca"] . "<br>" . "Modello: " . $row["modello"] . "<br>" . "Numero Posti: " . $row["posti"] . "<br>";
    
        }
    
    } else {
    
        echo "Nessun risultato trovato";
    
    }
    */
     
    /*
    // Esempio di DELETE
    
    $sql = "DELETE FROM nomi_tabella WHERE condizione";
    
    if (mysqli_query($conn, $sql)) {
    
        echo "Record eliminato con successo";
    
    } else {
    
        echo "Errore nell'eliminazione del record: " . mysqli_error($conn);
    
    }
    */
     

    // Esempio di INSERT
    /*

    $sql = "INSERT INTO nomi_tabella (colonna1, colonna2, colonna3) VALUES ('valore1', 'valore2', 'valore3')";

 

    if (mysqli_query($conn, $sql)) {

        echo "Dati inseriti con successo";

    } else {

        echo "Errore nell'inserimento dei dati: " . mysqli_error($conn);

    }
 */

    
    // Chiusura della connessione
    //mysqli_close($conn);
    
//--------------------------------------------------------------------------------------------------


    //function to generate a table with all the cars
    function printCars($conn){
        $sql = "SELECT * FROM car where deleted = 0 ";
    
        $result = mysqli_query($conn, $sql);
        
        
        echo "<form action='index.php' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Targa</th>";
        echo "<th>Marca</th>";
        echo "<th>Modello</th>";
        echo "<th>Numero Posti</th>";
        echo "<th><input type='checkbox' name='checkAll' id='checkAll' onChange='selezionaTutto()'></th>";
        echo "</tr>";

        if (mysqli_num_rows($result) > 0) {
        
        
           
            foreach ($result as $r) {
                $marca = $r["marca"];
                $sql = "SELECT * FROM Marche where id = $marca";
        
                $result2 = mysqli_query($conn, $sql);
        
                $r2 = $result2->fetch_assoc();
                echo "<tr>";
                echo "<td>" . $r["targa"] . "</td>";
                echo "<td>" . $r2["nome"] . "</td>";
                echo "<td>" . $r["modello"] . "</td>";
                echo "<td>" . $r["posti"] . "</td>";
                echo "<td><input type='checkbox' name='check[]' value='" . $r["id"] . "'></td>";
                echo "</tr>";
            
                }
        
        } else {
        
            echo "Nessun risultato trovato" . "<br>";
        
        }
        echo "</table>";
        echo "<input type='submit' name='submitElimina' value='Elimina' id='elimina'>";
        echo "</form>";
        
    }
    //printCars($conn);
    //$content = "";


    //function to add a car to the database
    if(isset($_POST['submitInserisci'])){
        //$file = fopen('data.txt', 'a+');
        $targa =$_POST["targa"];
        //$marca = str_replace(' ', '_',$_POST["marca"]);
        $idMarca =$_POST["marca"];
        $modello = str_replace(' ', '_',$_POST["modello"]);
        $nPosti =$_POST["nPosti"];
        

      

        // Esempio di INSERT

        $sql = "INSERT INTO car (targa, marca, modello, posti) VALUES ('$targa', $idMarca, '$modello', $nPosti)";

 

        if (mysqli_query($conn, $sql)) {

            echo "Dati inseriti con successo" . "<br>";

        } else {

            echo "Errore nell'inserimento dei dati: " . mysqli_error($conn) . "<br>";

        }
        printCars($conn);

        /*
        $content = add($targa, 6);
        $content .= add($marca, 20);
        $content .= add($modello, 20);
        $content .= add($nPosti, 3);
        $content .= PHP_EOL;
        fwrite($file, $content);
        fclose($file);
        echo "<script type='text/javascript'>alert('veicolo aggiunto con successo');</script>";
        echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
        */
        
    }

    
    //function to show the inventory
    if(isset($_POST['submitInventario'])){
        /*
        $file = fopen('data.txt', 'r');
        $size = filesize('data.txt');
        $content = fread($file, $size);
        for($i=0; $i<$size; $i++){
            if($content[$i] == PHP_EOL){
                echo "<br>";
            }else{
                echo $content[$i];
            }
        }
        fclose($file);*/
        printCars($conn);
    }

    
    //function to delete a car from the database
    if(isset($_POST['submitElimina'])){
        $idToDelete = $_POST['check'];
        foreach($idToDelete as $id){
            $sql = "UPDATE car SET deleted = 1 WHERE id = $id";
    
            if (mysqli_query($conn, $sql)) {
    
                echo "Record aggiornato con successo" . "<br>";
    
            } else {
    
                echo "Errore nell'aggiornamento del record: " . mysqli_error($conn) . "<br>";
    
            }
        }
        
        //var_dump($targaToDelete);
        printCars($conn);
        /*
        $file = fopen('data.txt', 'r');
        $tempFile = fopen('temp.txt', 'w');
        while(!feof($file)){
            $line = fgets($file);
            if(strpos($line, $targaToDelete) === false){
                fwrite($tempFile, $line);
            }
        }
        fclose($file);
        fclose($tempFile);
        unlink('data.txt');
        rename('temp.txt', 'data.txt');
        */
        //echo "<script type='text/javascript'>alert('veicolo eliminato con successo');</script>";
        //echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    }


    //function to search a car by license plate
    /*
    if(isset($_POST['submitRicerca'])){
        $targaToSearch =$_POST["Ricerca"];
        
        //$file = fopen('data.txt', 'r');
        
        //$found = false;
        $sql = "SELECT * FROM car where deleted = 0 and targa = '$targaToSearch'";
    
        $result = mysqli_query($conn, $sql);
        
        
        
        if (mysqli_num_rows($result) > 0) {
           
            foreach ($result as $r) {
                $marca = $r["marca"];
                $sql = "SELECT * FROM Marche where id = $marca";
    
                $result2 = mysqli_query($conn, $sql);
    
                $r2 = $result2->fetch_assoc();
        
                echo "ID: " . $r["id"] . " - Targa: " . $r["targa"] . "<br>";
                echo "Marca: " . $r2["nome"] . "<br>" . "Modello: " . $r["modello"] . "<br>" . 
                "Numero Posti: " . $r["posti"] . "<br>";
        
            }
            
        
        } else {
        
            echo "Nessun risultato trovato" . "<br>";
        
        }
        //printCars($conn);
        /*
        while(!feof($file)){
            $line = fgets($file);
            $vehicleData = explode(" ", $line);
            $targa = trim($vehicleData[0]);
            
            if($targa === $targaToSearch){
                $marca = substr($line, 7, 20);
                $modello = substr($line, 27, 20);
                $nPosti = substr($line, 47, 3);
                
                echo "Targa: " . $targa . "<br>";
                echo "Marca: " . $marca . "<br>";
                echo "Modello: " . $modello . "<br>";
                echo "Numero Posti: " . $nPosti . "<br>";
                
                $found = true;
                break;
            }
        }
        
        fclose($file);
        
        if(!$found){
            echo "<script type='text/javascript'>alert('Veicolo non trovato');</script>";
        }/
    }*/
    
    
    echo "</div>";
    mysqli_close($conn);

    
?>
