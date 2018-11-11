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
if ($lista_corsi){
    foreach($lista_corsi as $corso){
        $opzioni_corsi .= "<option value=\"$corso\">$corso</option>\n";
    }
}
//titoli
$opzioni_titolo = "";    
if ($lista_titoli){
    foreach($lista_titoli as $titolo){
        $opzioni_titolo .= "<option value=\"$titolo\">\n";
    }
}

//inserimento opzioni corsi nella pagina
$output = file_get_contents("../HTML/cercalibro.html");
$output = str_replace("££opzioni££",$opzioni_corsi,$output);
$output = str_replace("££titoli££",$opzioni_titolo,$output);
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
$output = str_replace("<footer></footer>",htmlMaker::footer(),$output);  


//stampa del body principale della pagina
echo $output;

?>
