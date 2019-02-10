<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";

$ris = "";
try{
      $libri = SqlWrap::query("SELECT Titolo,Autore,Prezzo,ISBN,md5_Hash FROM Libri_In_Vendita ORDER BY Codice_Vendita DESC LIMIT 4");
      if ($libri)
            $ris = htmlMaker::generateBookCollection($libri);
      else
            $ris = "<p>Sembra che non ci siano libri inseriti nel sito!</p>";
}catch(Exception $e) {
      $ris = "<p>Sembra che non ci siano libri inseriti nel sito!</p>";
}


$output = file_get_contents("../HTML/home.html");
echo str_replace('<a href="home.php">','<a>',
      str_replace("<nav></nav>",htmlMaker::navbar(),
      str_replace("<header></header>",htmlMaker::header(),
      str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb(),
      str_replace("££ULTIMI LIBRI££",$ris,
                 $output)))));
?>