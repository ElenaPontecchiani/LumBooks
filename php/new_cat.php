<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";

try{
    if(!sqlWrap::isAdmin())
        throw new Exception("Non sei amministratore");
    if (!isset( $_POST['titolo'],
                $_POST['autore'],
                $_POST['casaeditrice'],
                $_POST['corso']))
        throw new Exception("Richiesta Malformata");

    //Mi tiro giù variabili dalla post (per aumentare leggibilità codice)
    $titolo =           $_POST['titolo'];
    $autore =           $_POST['autore'];
    $casa_editrice =    $_POST['casaeditrice'];
    $corso =            $_POST['corso'];

    Validator::titoloVal($titolo);
    Validator::autoreVal($autore);
    Validator::corsoVal($casa_editrice);
    Validator::corsoVal($corso);

    sqlWrap::command("INSERT INTO Libri_Listati(Codice_Identificativo,Titolo,Autore,Casa_Editrice,Corso)
                            VALUES (NULL,'$titolo','$autore','$casa_editrice','$corso');");
    header('Location: admin.php');
    die();


} catch (Exception $e) {
    echo 'Errore: ',  $e->getMessage(), "\n";
}


?>