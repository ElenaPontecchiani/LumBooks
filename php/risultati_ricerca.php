<?php
include "Backend/sql_wrapper.php";
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

echo $query;
//FINE COMPOSIZIONE DELLA QUERY

$libri = SqlWrap::query($query);
print_r($libri);










?>