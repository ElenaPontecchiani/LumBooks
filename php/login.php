<?php
echo "<!DOCTYPE html>";
echo '<html lang="it">';

//HEAD
include "../HTML/head/login.html";



echo "<body>";


    $html = file_get_contents("../HTML/body/login.html");
    if(!isset($_SESSION))
      session_start();
    if(isset($_SESSION['login']) && !$_SESSION['login'])
    {
      $html = str_replace("<label id='loginError' class='hidden'>","<label id='loginError'>",$html);
      session_destroy();
    }
    include "../HTML/modules/header.html";
    include "../php/modules/navbar.php";

    echo $html;

    include "../HTML/modules/footer.html";

echo "</body>";


echo "</html>";


?>
