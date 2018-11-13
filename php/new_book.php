<?php
include "Backend/sql_wrapper.php";

//MANCA TIPO!

//QUA DEVO ALMENO VALIDARE I CAMPI CHE VANNO INSERITI IN ENTRAMBI I CASI
$titolo = $_POST['titolo'];
$autore = $_POST['autore'];
$casa_editrice = $_POST['casaeditrice'];
$corso = $_POST['corso'];
//validazione

$edizione = $_POST['edizione'];
$annopub = $_POST['anno'];
$isbn = $_POST['ISBN'];
$prezzo = $_POST['prezzo'];
//validazione

$libro_da_catalogo = $_POST['catalogo'];

$dati = [];
session_start();

if (isset($_POST['type'])){
    if($_POST['type'] == "listato" && $libro_da_catalogo){
        //caso precompilato
        $dati = SqlWrap::query(" SELECT Titolo, Autore, Casa_Editrice,Corso, Codice_identificativo as Codice_identificativo_Libro
                                    FROM Libri_Listati
                                    WHERE Titolo = '$libro_da_catalogo'",false)[0];
    }
    else if(($_POST['type'] == "personale")){
        //caso non precompilato
        $dati = array(  "Titolo" => $titolo,
                        "Autore" => $autore,
                        "Casa_Editrice" => $casa_editrice,
                        "Corso" => $corso);
    }
    else
        throw new Exception("Richiesta Malformata");
}
else
    throw new Exception("Richiesta Malformata");

//Aggiunta valori comuni
$dati = $dati + array(  "Stato" => "In vendita",
                        "Edizione" => $edizione,
                        "Anno_Pubblicazione" => $annopub,
                        "ISBN" => $isbn,
                        "Prezzo" => $prezzo,
                        "Data_Aggiunta" => date("Y-m-d"),
                        "Venditore" => $_SESSION['id']); 


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
SqlWrap::Command($insert);

echo "Libro Inserito con successo!";
?>