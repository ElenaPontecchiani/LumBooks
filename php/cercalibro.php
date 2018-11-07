<?php
echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/cercalibro.html";



echo "<body>";
    $p = "provalol2";
    $html = file_get_contents("../HTML/body/cercalibro.html");
    $html = str_replace("££prova££",$p,$html);


    include "../HTML/modules/header.html";
    include "../php/modules/navbar.php";
    
    echo $html;
    //include "../HTML/body/cercalibro.html";

    include "../HTML/modules/footer.html";
echo "</body>";


echo "</html>";
?>
