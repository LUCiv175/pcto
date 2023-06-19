<?php
    include "conn.php";

    $modelli = array();
    $sql = "SELECT * FROM modelli ";
    $result = mysqli_query($conn, $sql);
    while ($row = $result->fetch_assoc()) {
        $modelli[] = $row;
    }

  
?>

<!DOCTYPE html>
<html>

<head>
    <title>Autonoleggio</title>
    <link rel="stylesheet" href="stle.css">
    <link rel="icon" type="image" href="https://upload.wikimedia.org/wikipedia/it/thumb/e/ed/SSC_Napoli_2007.svg/1200px-SSC_Napoli_2007.svg.png">
    
</head>

<body>
    <div class="sito">
    <h1>Autonoleggio</h1>

    
    <form action="index.php" method="post" id="carInput">
        <label>Targa:</label>
        <input type="text" name="targa" required><br>
        <label>Marca:</label>
        <select name="marca" required id="selectMarca">
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
        <select id='selectModello' name="modello">
            <option disabled selcted value>Modello...</option>
            
        </select>
        <label>Numero Posti:</label>
        <select name="nPosti" required>
            <option disabled selcted value>Numero Posti...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
        </select>
        <input type="submit" name="submitInserisci" value="Aggiungi Veicolo">
    </form>
    <form action="index.php" method="post">
        <!---<input type="text" name="Elimina" required><br>
        <input type="submit" name="submitElimina" value="Elimina" id="elimina">-->
    </form>
    <form action="index.php" method="post">
        <input type="text" name="Ricerca" required><br>
        <input type="submit" name="submitRicerca" value="Ricerca">
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

        <?php
            $cleanArray = array();
            foreach($modelli as $element){
                $cleanElement = mb_convert_encoding($element, 'UTF-8', 'UTF-8');
                $cleanArray[] = $cleanElement;
            }
            $json = json_encode($cleanArray, true);
            if($json === false){
                $jsonError = json_last_error();
                switch($jsonError){
                    case JSON_ERROR_NONE:
                        echo ' - Nessun errore';
                    break;
                    case JSON_ERROR_DEPTH:
                        echo ' - Sforato la profondità massima';
                    break;
                    case JSON_ERROR_STATE_MISMATCH:
                        echo ' - Sottodimensionamento o mismatch dei modi';
                    break;
                    case JSON_ERROR_CTRL_CHAR:
                        echo " - Errore carattere di controllo, probabilmente codificato in UTF-8 ma non correttamente";
                    break;
                    case JSON_ERROR_SYNTAX:
                        echo ' - Errore di sintassi';
                    break;
                    case JSON_ERROR_UTF8:
                        echo ' - Carattere UTF-8 malformato, probabilmente codificato in UTF-8 ma non correttamente';
                    break;
                    case JSON_ERROR_RECURSION:
                        echo ' - Una o più referenze ricorsive nel valore da codificare';
                    break;
                    case JSON_ERROR_INF_OR_NAN:
                        echo ' - Uno o più valori NAN o INF nel valore da codificare';
                    break;
                    case JSON_ERROR_UNSUPPORTED_TYPE:
                        echo ' - Un valore di un tipo non supportato è stato dato, come un resource';
                    break;
                    case JSON_ERROR_INVALID_PROPERTY_NAME:
                        echo ' - Un nome di proprietà codificato in UTF-8 non è valido';
                    break;
                    case JSON_ERROR_UTF16:
                        echo ' - Carattere UTF-16 malformato, probabilmente codificato in UTF-8 ma non correttamente';
                    break;
                    default:
                        echo ' - Errore sconosciuto';
                }
            }
        ?>
        let modelli = <?php echo $json; ?>;
        let selectMarca = document.getElementById("selectMarca");
        selectMarca.onchange = () =>{
            let marca = selectMarca.value;
            let selectModello = document.getElementById("selectModello");
            selectModello.innerHTML = "";
            let option = document.createElement("option");
            option.disabled = true;
            option.selected = true;
            option.value = "";
            option.innerHTML = "Modello...";
            selectModello.appendChild(option);
            for(let i = 0; i < modelli.length; i++){
                if(modelli[i].id_marca === marca){
                    let option = document.createElement("option");
                    option.value = modelli[i].id;
                    option.innerHTML = modelli[i].modello;
                    selectModello.appendChild(option);
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
                echo "<td><input type='checkbox' name='check[]' value='" . $r["targa"] . "'></td>";
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
        $idModello = $_POST["modello"];
        $nPosti =$_POST["nPosti"];
      

        // Esempio di INSERT

        $sql = "INSERT INTO car (targa, id_marca, id_modello, posti) VALUES ('$targa', $idMarca, '$idModello', $nPosti)";

 

        if (mysqli_query($conn, $sql)) {

            echo "Dati inseriti con successo" . "<br>";

        } else {

            echo "Errore nell'inserimento dei dati: " . mysqli_error($conn) . "<br>";

        }
        //printCars($conn);

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
        var_dump($idToDelete);
        if(empty($idToDelete)){
            echo "<script type='text/javascript'>alert('nessun veicolo selezionato');</script>";
            echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
        }
        else{
            foreach($idToDelete as $id){
                $sql = "UPDATE car SET deleted = 1 WHERE id = $id";
                if (mysqli_query($conn, $sql)) {
        
                    echo "Record aggiornato con successo" . "<br>";
        
                } else {
        
                    echo "Errore nell'aggiornamento del record: " . mysqli_error($conn) . "<br>";
        
                }
            }
        }
        
        //var_dump($targaToDelete);
        //printCars($conn);
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
    


    if(isset($_POST['submitRicerca'])){
        $elementToSearch =$_POST["Ricerca"];
        
        //$file = fopen('data.txt', 'r');
        
        //$found = false;

        /*

        $sql2 = "SELECT * FROM Marche where nome LIKE  '%$elementToSearch%'";
        
        $result = mysqli_query($conn, $sql2);
        $sql3 = "SELECT * FROM modelli where nome='$elementToSearch'";
        
        $result2 = mysqli_query($conn, $sql3);
    
        if ($elementToSearch=='*'){
            $sql = "SELECT * FROM car where deleted = 0";
        }
        else{

            if (mysqli_num_rows($result2) > 0) {
                $modello1 = $result2->fetch_assoc();
                $modello1 = $modello1["id"];
            } else {
                $modello1 = -1;
            }


            if (mysqli_num_rows($result) > 0) {
                $marca1 = $result->fetch_assoc();
                $marca1 = $marca1["id"];
            } else {
                $marca1 = -1;
            }

            $sql = "SELECT * FROM car where (targa Like '%$elementToSearch%' or marca = $marca1 or modello=$modello1 or posti = '$elementToSearch') and deleted = 0";
        }
        $result = mysqli_query($conn, $sql);
    
        */
        
        if ($elementToSearch=='*'){
            $sql = "SELECT * FROM ((modelli inner join Marche on Marche.id = modelli.id_marca) inner join car on modelli.id = car.id_modello) where deleted = 0;";
        }
        else{
            $sql = "SELECT * FROM 
            car inner join Marche on Marche.id = car.id_marca 
            inner join modelli on modelli.id = car.id_modello 
            where (targa Like '%$elementToSearch%' or Marche.nome Like '%$elementToSearch%' or modelli.modello Like '%$elementToSearch%' or posti = '$elementToSearch') and deleted = 0";
        }$result = mysqli_query($conn, $sql);  
        //var_dump($result);
        /*
        if ($result) {
            $num_rows = mysqli_num_rows($result);
            echo "Numero di righe: " . $num_rows;
        } else {
            echo "Errore nella query: " . mysqli_error($conn);
        }*/
        //echo $sql;
        if(mysqli_num_rows($result) > 0) {

            echo "<form action='index.php' method='post'>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Targa</th>";
            echo "<th>Marca</th>";
            echo "<th>Modello</th>";
            echo "<th>Numero Posti</th>";
            echo "<th>Anno</th>";
            echo "<th><input type='checkbox' name='checkAll' id='checkAll' onChange='selezionaTutto()'></th>";
            echo "</tr>";

            foreach ($result as $r) {
                //var_dump($r);
                /*
                $marca = $r["marca"];
                $sql = "SELECT * FROM Marche where id = $marca";
                $result2 = mysqli_query($conn, $sql);
                $r2 = $result2->fetch_assoc();
                $modello = $r["modello"];
                $sql = "SELECT * FROM modelli where id = $modello";
                $result2 = mysqli_query($conn, $sql);
                $r3 = $result2->fetch_assoc();
                echo "<tr>";
                echo "<td>" . $r["targa"] . "</td>";
                echo "<td>" . $r2["nome"] . "</td>";
                echo "<td>" . $r3["modello"] . "</td>";
                echo "<td>" . $r["posti"] . "</td>";
                echo "<td><input type='checkbox' name='check[]' value='" . $r["id"] . "'></td>";
                echo "</tr>";
                */
                echo "<tr>";
                echo "<td>" . $r["targa"] . "</td>";
                echo "<td>" . $r["nome"] . "</td>";
                echo "<td>" . $r["modello"] . "</td>";
                echo "<td>" . $r["posti"] . "</td>";
                echo "<td>" . $r["anno"] . "</td>";

                echo "<td><input type='checkbox' id='checkElimina' name='check[]' value='" . $r["id"] . "'></td>";
                echo "</tr>";
            
            }
            echo "</table>";
            echo "<input type='submit' name='submitElimina' value='Elimina' id='elimina'>";
            echo "</form>";
            
        
        } else {
        
            echo "Nessun risultato trovato" . "<br>";
        
        }
    }
    echo "</div>";
    mysqli_close($conn);
    

?>