<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";
session_start();
if (isset($_SESSION['id'])){
    
    $lista_titoli = SqlWrap::query("SELECT distinct Titolo FROM Libri_Listati",true);
    $opzioni_titolo = "";    
    if ($lista_titoli){
        foreach($lista_titoli as $titolo){
            $opzioni_titolo .= "<option value=\"$titolo\">$titolo</option>\n";
        }
    }
    
    $output = file_get_contents("../HTML/inserisci.html");

    $output = str_replace("££opzioni_titolo££",$opzioni_titolo,$output);
    $output = str_replace("<header></header>",htmlMaker::header(),$output);
    $output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
    echo $output;
}
else
    echo "<p>Questa funzione è disponibile solo per utenti iscritti</p>";
?>