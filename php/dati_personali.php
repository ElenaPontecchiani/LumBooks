<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";

session_start();

$output = file_get_contents("../HTML/dati_personali.html");
echo str_replace("<nav></nav>",htmlMaker::navbar(),
     str_replace("<header></header>",htmlMaker::header(),
     str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("I miei dati"),
     
     str_replace("££nome££",$_SESSION['nome'],
     str_replace("££cognome££",$_SESSION['cogn'],
     str_replace("££datanascita££",$_SESSION['bdate'],
     str_replace("££mail££",$_SESSION['email'],
                 $output)))))));
?>