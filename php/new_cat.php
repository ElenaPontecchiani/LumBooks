<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/validator.php";
require_once "Backend/htmlMaker.php";

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
    sqlWrap::input_escape(array(&$titolo,&$autore,&$casa_editrice,&$corso,));
    Validator::titoloVal($titolo);
    Validator::autoreVal($autore);
    Validator::corsoVal($casa_editrice);
    Validator::corsoVal($corso);

    sqlWrap::command("INSERT INTO Libri_Listati(Codice_Identificativo,Titolo,Autore,Casa_Editrice,Corso)
                            VALUES (NULL,'$titolo','$autore','$casa_editrice','$corso');");
    header('Location: admin.php');
    die();


} catch (Exception $e) {
    echo htmlMaker::pagina_messaggio("Operazione non riuscita!","Ecco cosa hai sbagliato nello specifico: {$e->getMessage()}");
}


?>