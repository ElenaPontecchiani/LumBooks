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

//Escape di tutti gli input
//Tutti insieme per minimiazzare accesso al db
SqlWrap::input_escape(array(  &$scelta_list,&$titolo,&$autore,&$casa_editrice,
                        &$corso,&$edizione,&$annopub,&$isbn,
                        &$prezzo,&$libro_catalogo));

//A seconda della scelta dell'utente (listato vs libero), controllo solo
//i campi necessari
if ($scelta_list == "listato"){
    $scelta_list = true;
    if(!Validator::lengthVal(3,50,$libro_catalogo))
        throw new Exception("Lunghezza libro da catalogo errata");
}
else{
    $scelta_list = false;
    if(!Validator::lengthVal(3,50,$titolo,$autore,$corso,$casa_editrice))
        throw new Exception("Lunghezze sbagliate o campi vuoti");
  
}

//Annopub può essere null oppure un anno valido
if ($annopub != "" &&
    (!filter_var($annopub, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1900, "max_range"=>2100)))))
    throw new Exception("Anno non valido");

//Saranno necessari controlli per stabilire che valore di ezione sia corretto
#############################################################################
if((!Validator::lengthVal(3,20,$edizione)) && $edizione != "")
    throw new Exception("Edizione non valida");

//Validazione anno di pubblicazione
if  (( (!(filter_var($annopub, FILTER_VALIDATE_INT))) || strlen($isbn) != 13) && $annopub != "")
    throw new Exception("ISBN non valido");

//Validazione del prezzo
$prezzo = str_replace(",",".",$prezzo);
$pattern = '/^\d+(?:\.\d{2})?$/';
if (!preg_match($pattern, $prezzo)) {
    throw new Exception("Prezzo non valido");
 }
    
                        




############## FINE VAL ###################

$dati = [];
session_start();

if($scelta_list){
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
echo $insert;
SqlWrap::Command($insert);

echo "Libro Inserito con successo!";
?>