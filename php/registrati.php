<?php
include "Backend/htmlMaker.php";

$output = file_get_contents("../HTML/registrati.html");
$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
$output = str_replace("<footer></footer>",htmlMaker::footer(),$output); 
echo $output;
?>
