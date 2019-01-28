<?php
require_once "Backend/htmlMaker.php";
$output = file_get_contents("../HTML/about.html");
echo str_replace("<nav></nav>",htmlMaker::navbar(),
      str_replace('<a href="about.php">','',
      str_replace("</h1></a>","</h1>",
      str_replace("<header></header>",htmlMaker::header(),
      str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("Inserisci"),$output,
                 $output)))));
?>
