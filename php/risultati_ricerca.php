<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/htmlMaker.php";
require_once "Backend/validator.php";

$titolo = $_GET['titolo'];
$autore = $_GET['autore'];
$isbn = $_GET['isbn'];
$corso = $_GET['corso'];


/*
    *  ######## IMPORTANTE #################
    *  BISOGNA SANIFICARE INPUT E FARE CONTROLLI
    *  TRIMMARE ECC
    */

//escape dell'input
SqlWrap::input_escape( array(&$titolo,&$autore,&$isbn,&$corso) );
$correctSqlInput = Validator::ricercaValidation($titolo,$autore,$isbn,$corso);

//#todo >>>>>>>>>>>>>> visualizzare un errore e riempire i campi <<<<<<<<<<<<
if($isbn == "error"){
  $location = ('Location: cercalibro.php?titolo='.$titolo.'&autore='.$autore.'&isbn='.$isbn.'&corso='.$corso);
  header($location);
  exit();
}
  //INZIO COMPOSIZIONE DELLA QUERY"
  $query = "  SELECT Titolo,Autore,Prezzo,ISBN,md5_Hash
              FROM Libri_In_Vendita WHERE 1=1 ";

  if (!($titolo == ""))
      $query.= " AND Titolo like '%$titolo%'";
  if (!($autore == ""))
      $query.= " AND Autore like '%$autore%'";
  if (!($isbn == ""))
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
$output = file_get_contents("../HTML/risultati_ricerca.html");
$output = str_replace("££RISULTATI££",$ris,$output);
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);
$output = str_replace("<footer></footer>",htmlMaker::footer(),$output);

echo $output;



?>
