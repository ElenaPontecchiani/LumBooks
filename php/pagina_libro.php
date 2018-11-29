<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";
require_once "Backend/htmlMaker.php";

$output = file_get_contents("../HTML/libro.html");
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
$output = str_replace("<footer></footer>",htmlMaker::footer(),$output); 


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


    $book_data = sqlWrap::query("SELECT Titolo,
                                        Autore,
                                        Casa_Editrice as Editore,
                                        ISBN,
                                        Tipo,
                                        Anno_Pubblicazione as 'Anno di Pubblicazione',
                                        Corso,
                                        Stato,
                                        Data_Aggiunta as 'Data di Aggiunta',
                                        CONCAT(Nome,' ',Cognome) as Venditore,
                                        Prezzo 
                                FROM Libri_In_Vendita
                                JOIN Utente ON Venditore = Codice_identificativo
                                WHERE md5_Hash = \"$book_hash\"");

    if ($book_data == null){//Se la query è vuota
        throw new Exception("Per quualche oscuro motivo quacosa è andato storto. Bah...");
    }
    $book_data = $book_data[0];
    //query ok;

    $output = str_replace("££TITOLO££",$book_data['Titolo'],$output);
    $output = str_replace("££AUTORE££",$book_data['Autore'],$output);

    $keys = array_diff(array_keys($book_data),array("Titolo","Autore"));

    $attr_list = "";
    foreach($keys as $key){
        if($book_data[$key] != "")
            $attr_list .= "<dt>$key:</dt>\n<dd>{$book_data[$key]}</dd>\n";
    }

    $output = str_replace("££LISTA_ATTRIBUTI££",$attr_list,$output);


    /*$output = str_replace("££TIPO££",$book_data['Tipo'],$output);
    $output = str_replace("££EDIZIONE££",$book_data['Edizione'],$output);
    $output = str_replace("££ISBN££",$book_data['ISBN'],$output);
    $output = str_replace("££ANNO££",$book_data['Anno_pub'],$output);
    $output = str_replace("££CORSO££",$book_data['Corso'],$output);
    $output = str_replace("££STATO££",$book_data['Stato'],$output);
    $output = str_replace("££DATA££",$book_data['Data_Aggiunta'],$output);
    $output = str_replace("££VENDITORE££",$book_data['Venditore'],$output);
    $output = str_replace("££PREZZO££",$book_data['Prezzo'],$output);*/

}catch(Exception $e){
    echo $e->getMessage();
}



echo $output;
?>


