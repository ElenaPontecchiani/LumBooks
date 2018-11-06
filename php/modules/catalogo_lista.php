<?php
    include "phpConnect.php";
    if(!$result = $connect->query("SELECT * FROM Libri_Listati")){
        echo "Errore di query";
        exit();
    }
    else{
        $connect->close();
    }
    if($result->num_rows > 0){
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $str = 	'<dl class="search_item">
                            <dt class="item_name">'.$row['Titolo'].'</dt>
                            <dt class="item_spec">Autore</dt><dd class="spec_desc">'.$row['Autore'].'</dt>
                            <dt class="item_spec">Casa Editrice</dt><dd class="spec_desc">'.$row['Casa_Editrice'].'</dt>
                            <dt class="item_spec">Corso</dt><dd class="spec_desc">'.$row['Corso'].'</dt></dl>';
            $str = mb_convert_encoding($str, "utf-8", "auto");
            echo $str;
        }
        $result->free();
    }
?>