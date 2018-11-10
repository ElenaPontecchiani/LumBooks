<?php
//importazione della classe sql wrapper
require_once("Backend/sql_wrapper.php");

echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/cercalibro.html";



echo "<body>";
    
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
    $html = file_get_contents("../HTML/body/cercalibro.html");
    $html = str_replace("££opzioni££",$opzioni_corsi,$html);
    $html = str_replace("££titoli££",$opzioni_titolo,$html);  

    include "../HTML/modules/header.html";
    include "../php/modules/navbar.php";
    
    //stampa del body principale della pagina
    echo $html;

    include "../HTML/modules/footer.html";
echo "</body>";


echo "</html>";
?>
