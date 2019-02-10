<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/htmlMaker.php";
require_once "Backend/validator.php";

$titolo = '';
$autore = '';
$isbn = '';
$corso = '';
$desc = '';
$editore = '';
if(isset($_GET['titolo']))
  $titolo = $_GET['titolo'];
if(isset($_GET['autore']))
  $autore = $_GET['autore'];
if(isset($_GET['isbn']))
  $isbn = $_GET['isbn'];
if(isset($_GET['Editore']))
  $editore = $_GET['Editore'];
if(isset($_GET['corso']))
  $corso = $_GET['corso'];
if(isset($_GET['keyword']))
  $desc = $_GET['keyword'];


//escape dell'input
SqlWrap::input_escape( array(&$titolo,&$autore,&$isbn,&$corso,&$editore) );
$correctSqlInput = Validator::ricercaValidation($titolo,$autore,$isbn,$corso,$editore);

if($isbn == "error") {
  $location = ('Location: cercalibro.php?titolo='.$titolo.'&autore='.$autore.'&isbn='.$isbn.'&corso='.$corso);
  header($location);
  exit();
}
  //INZIO COMPOSIZIONE DELLA QUERY"
  $query = "  SELECT Titolo,Autore,Prezzo,ISBN,md5_Hash
              FROM Libri_In_Vendita WHERE Stato = 'In vendita' ";

  if (!($titolo == ""))
      $query.= " AND Titolo like '%$titolo%'";
  if (!($autore == ""))
      $query.= " AND Autore like '%$autore%'";
  if (!($isbn == ""))
      $query.= " AND ISBN = $isbn";
  if (!($editore == ""))
      $query.= " AND Casa_Editrice like '%$editore%'";
  if (!($corso == "Qualsiasi" || $corso==""))
      $query.= " AND Corso = '%$corso%'";
  if (!($desc == ""))
      $query.= " AND Descrizione like '%$desc%'";
  $query .= " AND 1 = 1; ";

  //FINE COMPOSIZIONE DELLA QUERY

  $libri = SqlWrap::query($query);

if ($libri)
    $ris = htmlMaker::generateBookCollection($libri);
else
    $ris = "<p>Ti è andata male, non ho trovato niente.</p> <a href='cercalibro.php'>Prova con una nuova ricerca!</a>";
$output = file_get_contents("../HTML/risultati_ricerca.html");
$output = str_replace("££RISULTATI££",$ris,$output);
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("Cerca un Libro","Risultati ricerca"),$output);
$output = str_replace('<a href="../php/risultati_ricerca.php?">','<a>', $output);

echo $output;



?>
