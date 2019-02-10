<?php
//importazione della classe sql wrapper
require_once("Backend/sql_wrapper.php");
require_once("Backend/htmlMaker.php");

//lista corsi e titoli sono array di stringhe
$lista_corsi = SqlWrap::query("SELECT distinct Corso FROM Libri_Listati",true);
$lista_titoli = SqlWrap::query("SELECT distinct Titolo FROM Libri_Listati",true);

/*creazione html da inserire*/
//corsi
$opzioni_corsi = "";
if ($lista_corsi) {
    foreach($lista_corsi as $corso) {
        $opzioni_corsi .= "<option value=\"$corso\">$corso</option>\n";
    }
}
//titoli
$opzioni_titolo = "";
if ($lista_titoli) {
    foreach($lista_titoli as $titolo) {
        $opzioni_titolo .= "<option value=\"$titolo\">\n";
    }
}

//inserimento opzioni corsi nella pagina
$output = file_get_contents("../HTML/cercalibro.html");
$output = str_replace("££opzioni££",$opzioni_corsi,$output);
$output = str_replace("££titoli££",$opzioni_titolo,$output);
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);
$output = str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("Cerca un Libro"),$output);


//In caso di errore, riempio di nuovo il form
if(isset($_GET["titolo"]))
$output = str_replace('name="titolo"','name="titolo" value="'.$_GET["titolo"].'"',$output);
if(isset($_GET['autore']))
$output = str_replace('name="autore"','name="autore" value="'.$_GET['autore'].'"',$output);
if(isset($_GET['isbn']) && $_GET['isbn']!="error")
$output = str_replace('name="isbn"','name="isbn" value="'.$_GET['isbn'].'"',$output);
if(isset($_GET['corso']))
$output = str_replace('name="corso"','name="corso" value="'.$_GET['corso'].'"',$output);
$output = str_replace('<a href="cercalibro.php">','<a>',$output);
//stampa del body principale della pagina
echo $output;

?>
