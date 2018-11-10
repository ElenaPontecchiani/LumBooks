<?php
include "Backend/sql_wrapper.php";
include "Backend/htmlMaker.php";
$titolo = $_POST['titolo']; 
$autore = $_POST['autore'];
$isbn = $_POST['isbn'];
$corso = $_POST['corso'];


/*
    *  ######## IMPORTANTE #################
    *  BISOGNA SANIFICARE INPUT E FARE CONTROLLI
    *  TRIMMARE ECC
    */ 
/*if( $titolo == "" and
    $autore == "" and
    $isbn == null and
    $corso == "" and
    $ordine == "")
    return array("error" => "Richiesta vuota");
*/

//escape dell'input
SqlWrap::input_escape( array(&$titolo,&$autore,&$isbn,&$corso) );


//INZIO COMPOSIZIONE DELLA QUERY"
$query = "  SELECT Titolo,Autore,Prezzo,ISBN
            FROM Libri_In_Vendita WHERE 1=1 ";

if (!($titolo == ""))
    $query.= " AND Titolo like '%$titolo%'";
if (!($autore == ""))
    $query.= " AND Autore like '%$autore%'";
if (!($isbn == null))
    $query.= " AND ISBN = $isbn";
if (!($corso == "Qualsiasi"))
    $query.= " AND Corso like '%$corso%'";
$query .= " AND 1 = 1; ";

//FINE COMPOSIZIONE DELLA QUERY

$libri = SqlWrap::query($query);
if ($libri)
    $ris = htmlMaker::searchItem($libri);
else
    $ris = "NESSUN RISULTATO CORRISPONDENTE";
$html = file_get_contents("../HTML/body/risultati_ricerca.html");
$html = str_replace("££RISULTATI££",$ris,$html);


echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/risultati_ricerca.html";

echo "<body>";
    include "../HTML/modules/header.html";
    include "../php/modules/navbar.php";
    echo $html;

echo "</body>";
echo "</html>";





?>