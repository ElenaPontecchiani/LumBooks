<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";

$query = "  SELECT Titolo,Autore,Casa_Editrice as Editore, Corso
            FROM Libri_Listati";
$libri = htmlMaker::generateBookCollection(SqlWrap::query($query));
$output = file_get_contents("../HTML/catalogo.html");
$output = str_replace("<ul class='books_colelction'></ul>",$libri,$output);
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);
$output = str_replace("<footer></footer>",htmlMaker::footer(),$output); 

echo $output;

?>
