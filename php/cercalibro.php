<?php
echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/cercalibro.html";



echo "<body>";
    require_once("Backend/sql_wrapper.php");
    $lista_corsi = SqlWrap::query("SELECT distinct Corso FROM Libri_Listati",true);
    echo $lista_corsi;
    $course_option_html = "";
    foreach($lista_corsi as $corso){
        $course_option_html .= "<option value=\"$corso\">$corso</option>\n";
    }
    $html = file_get_contents("../HTML/body/cercalibro.html");
    $html = str_replace("££opzioni££",$course_option_html,$html);


    include "../HTML/modules/header.html";
    include "../php/modules/navbar.php";
    
    echo $html;
    //include "../HTML/body/cercalibro.html";

    include "../HTML/modules/footer.html";
echo "</body>";


echo "</html>";
?>
