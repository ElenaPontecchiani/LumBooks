<?php
echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/catalogo.html";



echo "<body>";


    include "../HTML/modules/header.html";
    include "../HTML/modules/navbar.html";
    
    echo '<div class="outerbox">';
    include "../HTML/body/catalogo.html";
    include "modules/catalogo_lista.php";
    echo '</div>';
    include "../HTML/modules/footer.html";

echo "</body>";


echo "</html>";
?>
