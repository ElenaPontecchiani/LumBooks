<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";

################ VALIDAZIONE ###############
//Controllo di aver ricevuto in post tutte le variabili
if (!isset( $_POST['type'],
            $_POST['titolo'],
            $_POST['autore'],
            $_POST['edizione'],
            $_POST['casaeditrice'],
            $_POST['corso'],
            $_POST['anno'],
            $_POST['ISBN'],
            $_POST['prezzo'],
            $_POST['catalogo']))
    throw new Exception("Richiesta Malformata");

//Mi tiro giù variabili dalla post (per aumentare leggibilità codice)
$scelta_list =      $_POST['type'];
$titolo =           $_POST['titolo'];
$autore =           $_POST['autore'];
$casa_editrice =    $_POST['casaeditrice'];
$corso =            $_POST['corso'];
$edizione =         $_POST['edizione'];
$annopub =          $_POST['anno'];
$isbn =             $_POST['ISBN'];
$prezzo =           $_POST['prezzo'];
$libro_catalogo =   $_POST['catalogo'];

try{
    $prezzo = str_replace(",",".",$prezzo);
    Validator::registerVal( $scelta_list, $titolo, $autore, $casa_editrice,
                            $corso, $edizione, $annopub, $isbn, $prezzo, $libro_catalogo); 
        
    
    



    ############## FINE VAL ###################

    $dati = [];
    session_start();

    if($scelta_list == "listato"){
        //caso precompilato
        $dati = SqlWrap::query("SELECT Titolo, Autore, Casa_Editrice,Corso, Codice_identificativo as Codice_identificativo_Libro
                                FROM Libri_Listati
                                WHERE Titolo = '$libro_catalogo'",false)[0];
    }
    else{
        //caso non precompilato
        $dati = array(  "Titolo" => $titolo,
                        "Autore" => $autore,
                        "Casa_Editrice" => $casa_editrice,
                        "Corso" => $corso);
    }

    //generazione hashmd5
    $md5 = md5(time()+mt_rand());

    //Aggiunta valori comuni
    $dati = $dati + array(  "Stato" => "In vendita",
                            "Edizione" => $edizione,
                            "Anno_Pubblicazione" => $annopub,
                            "ISBN" => $isbn,
                            "Prezzo" => $prezzo,
                            "Data_Aggiunta" => date("Y-m-d"),
                            "Venditore" => $_SESSION['id'],
                            "md5_Hash" => $md5); 


    $par1 = "";
    $par2 = "";
    $keys = array_keys($dati);
    foreach($keys as $key){
        $par1 .= $key.",";
        if($dati[$key]!= null){
            if (gettype($dati[$key]) != "string")
                $par2 .= $dati[$key].",";
            else
                $par2 .= "'".$dati[$key]."'".",";
        }
        else
            $par2 .= "NULL,";
    }

    $par1 = substr($par1,0,-1);
    $par2 = substr($par2,0,-1);

    $insert = "INSERT INTO Libri_In_Vendita(".$par1.") VALUES(".$par2.");";
    echo $insert;
    SqlWrap::Command($insert);
    echo "Libro Inserito con successo!";
} catch (Exception $e) {
    echo 'Errore: ',  $e->getMessage(), "\n";
}


?>