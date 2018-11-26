<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";
try{    
    if (isset($_GET['libro'])){
        $book_hash = $_GET['libro'];
        $book_hash = trim($book_hash);
        if(!Validator::lengthVal(32,32,$book_hash))
            throw new Exception("Ops, qualcosa è andato storto. Magari hai copiato male il link");
        sqlWrap::input_escape(array(&$book_hash));
    }    
        
    else
        throw new Exception("Ops, qualcosa è andato storto. Magari hai copiato male il link");


    $book_data = sqlWrap::query("SELECT * FROM Libri_In_Vendita WHERE md5_Hash = \"$book_hash\"");
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