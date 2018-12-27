<?php
require_once "Backend/htmlMaker.php";

$output = file_get_contents("../HTML/login.html");

if(!isset($_SESSION))
  session_start();
if(isset($_SESSION['login']) && !$_SESSION['login']){
  $output = str_replace("<label id='loginError' class='hidden'>","<label id='loginError'>",$output);
  session_destroy();
}

$output = str_replace("<header></header>",htmlMaker::header(),$output);
$output = str_replace("<nav></nav>",      htmlMaker::navbar(),$output);  
echo $output;


?>
