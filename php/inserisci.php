<?php
include "Backend/htmlMaker.php";
session_start();
if (isset($_SESSION['id'])){
    $output = file_get_contents("../HTML/inserisci.html");

    $output = str_replace("<header></header>",htmlMaker::header(),$output);
    $output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
    $output = str_replace("<footer></footer>",htmlMaker::footer(),$output); 
    echo $output;
}
else
    echo "<p>Questa funzione è disponibile solo per utenti iscritti</p>";
?>