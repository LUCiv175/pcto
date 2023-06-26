<?php
    include("../conn.php");
    
    $ricerca = $_REQUEST['q'];
    if(empty($ricerca)){
        $sql = "SELECT nome, modello, modelli.id_marca, targa, modelli.id FROM Marche inner join modelli on Marche.id=modelli.id_marca left join car on car.id_modello=modelli.id ORDER by nome, modello";
    }
    else{
        $sql = "SELECT nome, modello, modelli.id_marca, targa, modelli.id FROM Marche inner join modelli on Marche.id=modelli.id_marca left join car on car.id_modello=modelli.id where nome like '%$ricerca%' or modello like '%$ricerca%' order by nome, modello";
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
                'nome' => $row['nome'],
                'modello' => $row['modello'],
                'id_marca' => $row['id_marca'],
                'targa' => $row['targa'],
                'id' => $row['id']
            ];
            $json[] = $temp;
        }
    }
    echo json_encode($json);
    ?>