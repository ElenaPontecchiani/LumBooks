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
    $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '$hash'",true)[0];
    if ($_SESSION['id'] != $user){
        throw new Exception("Non fare il furbetto");
    }                       



    ############## FINE VAL ###################

    $modify = " UPDATE Libri_In_Vendita
                SET Titolo = '$titolo',
                    Autore = '$autore',
                    Casa_editrice = '$casa_editrice',
                    Corso = '$corso',
                    Edizione = '$edizione',
                    Anno_Pubblicazione = '$annopub',
                    ISBN = '$isbn',
                    Prezzo = '$prezzo'
                WHERE md5_Hash = '$hash'";
    echo $modify;
    SqlWrap::Command($modify);
    echo "Libro Modificato con successo";
} catch (Exception $e) {
    echo 'Errore: ',  $e->getMessage(), "\n";
}


?>