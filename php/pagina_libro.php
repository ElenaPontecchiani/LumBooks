<?php
require_once "Backend/sql_wrapper.php";
try{    
    if (isset($_GET['libro']))    
        $book_hash = $_GET['libro'];
    else
        throw new Exception("Ops, qualcosa è andato storto. Magari hai copiato male il link");
    //sanificazione input



    //da qua in poi l'input è considerato corretto
    $book_data = sqlWrap::query("SELECT * FROM Libri_In_Vendita WHERE md5Hash = \"$book_hash\"");
    if ($book_data != null){
        print_r($book_data);
    }
    else{//Se la query è vuota
        throw new Exception("Sembra che questo libro non sia disponibile!");
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>