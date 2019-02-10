<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";

################ VALIDAZIONE ###############
//Controllo di aver ricevuto in post tutte le variabili
if (!isset( $_POST['hash'],
            $_POST['titolo'],
            $_POST['autore'],
            $_POST['edizione'],
            $_POST['casaeditrice'],
            $_POST['corso'],
            $_POST['anno'],
            $_POST['ISBN'],
            $_POST['prezzo']))
    throw new Exception("Richiesta Malformata");

//Mi tiro giù variabili dalla post (per aumentare leggibilità codice)
$hash =             $_POST['hash'];
$titolo =           $_POST['titolo'];
$autore =           $_POST['autore'];
$casa_editrice =    $_POST['casaeditrice'];
$corso =            $_POST['corso'];
$edizione =         $_POST['edizione'];
$annopub =          $_POST['anno'];
$isbn =             $_POST['ISBN'];
$prezzo =           $_POST['prezzo'];



try{
    /*Validator::registerVal( $hash,$titolo, $autore, $casa_editrice,
                            $corso, $edizione, $annopub, $isbn, $prezzo); */
    
    session_start();
    
    $inputs = array(&$hash,&$titolo,&$autore,&$casa_editrice,&$corso,&$edizione,&$annopub,&$isbn,&$prezzo);
    array_walk($inputs,'trim');
    sqlWrap::input_escape($inputs);
    $prezzo = str_replace(",",".",$prezzo);
    sqlWrap::input_escape($inputs);
    Validator::corsoVal($corso);
    Validator::autoreVal($autore);
    Validator::titoloVal($titolo);
    Validator::edizioneVal($edizione);
    Validator::annoVal($annopub);
    Validator::edizioneVal($edizione);
    Validator::ISBNVal($isbn);
    Validator::prezzoVal($prezzo); 
    ############## FINE VAL ###################
    if($annopub == "")
        $annopub = 'NULL';

    if($isbn == "")
        $isbn = 'NULL';

    $vecchio_libro = sqlWrap::query("SELECT * FROM Libri_In_Vendita WHERE md5_Hash = '$hash'")[0];
    if ($_SESSION['id'] != $vecchio_libro['Venditore']){//controllo che sto modficando un libro che mi appartiene
        throw new Exception("Non fare il furbetto");
    }    
    

    //Se viene modificato il titolo o l'autore, il libro non rientra più in catalogo.
    $ref = "";
    if( $vecchio_libro['Titolo'] != $titolo ||
        $vecchio_libro['Autore'] != $autore) {
            $ref = "Codice_identificativo_Libro = NULL,";
        }

    $modify = " UPDATE Libri_In_Vendita
                SET Titolo = '$titolo',
                    Autore = '$autore',
                    Casa_Editrice = '$casa_editrice',
                    Corso = '$corso',
                    Edizione = '$edizione',
                    Anno_Pubblicazione = '$annopub',
                    ISBN = '$isbn',
                    $ref
                    Prezzo = '$prezzo'
                WHERE md5_Hash = '$hash'";

    $modify = str_replace("'NULL'","NULL",$modify);
    SqlWrap::Command($modify);

    header('Location: libri_personali.php');
    die();
} catch (Exception $e) {
    echo 'Errore: ',  $e->getMessage(), "\n";
}


?>