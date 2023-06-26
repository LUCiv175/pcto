<?php
    include("conn.php");
    
    $ricerca = $_REQUEST['q'];
    if(empty($ricerca)){
        $sql = "SELECT * FROM ((modelli inner join Marche on Marche.id = modelli.id_marca) inner join car on modelli.id = car.id_modello) where deleted = 0";
    }
    else{
        $sql = "SELECT * FROM 
        car inner join Marche on Marche.id = car.id_marca 
        inner join modelli on modelli.id = car.id_modello 
        where (targa Like '%$ricerca%' or Marche.nome Like '%$ricerca%' or modelli.modello Like '%$ricerca%' or posti = '$ricerca') and deleted = 0";
    }
    $result = mysqli_query($conn, $sql);
    $json = array();
    if (mysqli_num_rows($result) > 0) {
            /*
            echo "<form action='index.php' method='post'>";
            echo "<table id='tableRicerca'>";
            echo "<tr>";
            echo "<th>Targa</th>";
            echo "<th>Marca</th>";
            echo "<th>Modello</th>";
            echo "<th>Numero Posti</th>";
            echo "<th>Anno</th>";
            echo "<th><input type='checkbox' name='checkAll' id='checkAll' onChange='selezionaTutto()'></th>";
            echo "</tr>";
            */
        while($row = mysqli_fetch_assoc($result)) {
            $temp = [
            'id' => $row['id'],
            'targa' => $row['targa'],
            'marca' => $row['nome'],
            'modello' => $row['modello'],
            'posti' => $row['posti'],
            'anno' => $row['anno']
            ];
            $json[] = $temp;
        }
    }
    echo json_encode($json);
    ?>